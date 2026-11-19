// Custom dropdowns
// ----------------
// Every <select data-dropdown> in the Blade views is turned into a styled dropdown
// (a button + a list) instead of the browser's default select menu.
//
// The real <select> is only hidden, not removed. It stays inside the form, so:
//   - Laravel still receives the chosen value when the form is submitted
//   - old() and @selected still work, because we read the selected option on page load
// Choosing an item in our list just changes the hidden <select>'s value.

const chevronIcon = `
    <svg class="dropdown-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor"
         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m6 9 6 6 6-6"/>
    </svg>`;

document.querySelectorAll('select[data-dropdown]').forEach(createDropdown);

function createDropdown(select) {
    // ----- 1. Build the HTML -----

    // the wrapper holds the hidden select, the button and the menu
    const wrapper = document.createElement('div');
    wrapper.className = 'dropdown';
    select.before(wrapper);
    select.hidden = true;

    // the button that shows the chosen option (looks like the other inputs)
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'form-input dropdown-button';
    button.setAttribute('aria-haspopup', 'listbox');
    button.setAttribute('aria-expanded', 'false');
    button.innerHTML = '<span class="truncate"></span>' + chevronIcon;
    const buttonText = button.querySelector('span');

    // make the field's <label for="..."> open our button instead of the hidden select
    if (select.id) {
        button.id = select.id + '-button';
        const label = document.querySelector(`label[for="${select.id}"]`);
        if (label) label.htmlFor = button.id;
    }

    // the list of options, one <li> for each <option>
    const menu = document.createElement('ul');
    menu.className = 'dropdown-menu';
    menu.setAttribute('role', 'listbox');

    for (const option of select.options) {
        const item = document.createElement('li');
        item.className = 'dropdown-item';
        item.setAttribute('role', 'option');
        item.tabIndex = -1; // can get focus from the arrow keys, but is skipped by Tab
        item.textContent = option.textContent.trim(); // textContent = safe, no HTML
        item.dataset.value = option.value;
        item.addEventListener('click', () => choose(option.value));
        menu.append(item);
    }

    wrapper.append(select, button, menu);
    const items = [...menu.children];

    // ----- 2. Small helper functions -----

    // show the selected option's text on the button and mark it in the list
    function showSelected() {
        buttonText.textContent = select.options[select.selectedIndex].textContent.trim();
        buttonText.classList.toggle('dropdown-placeholder', select.value === ''); // "-- Choose --" looks gray

        for (const item of items) {
            item.setAttribute('aria-selected', item.dataset.value === select.value);
        }
    }

    function open() {
        wrapper.classList.add('is-open');
        button.setAttribute('aria-expanded', 'true');
        // start keyboard focus on the chosen item
        items[select.selectedIndex].focus();
    }

    function close() {
        wrapper.classList.remove('is-open');
        button.setAttribute('aria-expanded', 'false');
    }

    function isOpen() {
        return wrapper.classList.contains('is-open');
    }

    // save the value into the real <select>, then close the menu
    function choose(value) {
        select.value = value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        showSelected();
        close();
        button.focus();
    }

    // ----- 3. Events -----

    button.addEventListener('click', () => (isOpen() ? close() : open()));

    // clicking anywhere outside this dropdown, or tabbing away from it, closes it
    document.addEventListener('click', (event) => {
        if (!wrapper.contains(event.target)) close();
    });
    wrapper.addEventListener('focusout', (event) => {
        if (!wrapper.contains(event.relatedTarget)) close();
    });

    // keyboard: arrows move up/down, Enter/Space picks, Escape closes
    wrapper.addEventListener('keydown', (event) => {
        const current = items.indexOf(document.activeElement);

        if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
            event.preventDefault(); // don't scroll the page
            if (!isOpen()) return open();

            const step = event.key === 'ArrowDown' ? 1 : -1;
            const next = Math.min(Math.max(current + step, 0), items.length - 1);
            items[next].focus();
        } else if ((event.key === 'Enter' || event.key === ' ') && current !== -1) {
            event.preventDefault(); // don't submit the form
            choose(items[current].dataset.value);
        } else if (event.key === 'Escape' && isOpen()) {
            close();
            button.focus();
        }
    });

    showSelected();
}
