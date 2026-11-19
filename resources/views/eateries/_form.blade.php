{{-- Shared form fields for create.blade.php and edit.blade.php.
     On create, $eatery is a new empty Eatery, so the fields start blank.
     On edit, old() falls back to the saved value from the database.
     ?-> (nullsafe) is used for the permit because a new eatery has no permit yet. --}}
@include('partials.errors')

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    {{-- Name --}}
    <div>
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $eatery->name) }}" class="form-input">
        @error('name')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- District --}}
    <div>
        <label for="district_id" class="form-label">District</label>
        <select id="district_id" name="district_id" class="form-input">
            <option value="">-- Choose a district --</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id) == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Address --}}
    <div class="md:col-span-2">
        <label for="address" class="form-label">Address</label>
        <input type="text" id="address" name="address" value="{{ old('address', $eatery->address) }}" class="form-input">
        @error('address')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Price range --}}
    <div>
        <label for="price_range" class="form-label">Price range</label>
        <select id="price_range" name="price_range" class="form-input">
            <option value="">-- Choose a price range --</option>
            <option value="budget" @selected(old('price_range', $eatery->price_range) == 'budget')>₱ Budget</option>
            <option value="mid" @selected(old('price_range', $eatery->price_range) == 'mid')>₱₱ Mid</option>
            <option value="splurge" @selected(old('price_range', $eatery->price_range) == 'splurge')>₱₱₱ Splurge</option>
        </select>
        @error('price_range')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Specialty --}}
    <div>
        <label for="specialty" class="form-label">Specialty <span class="muted text-sm">(optional)</span></label>
        <input type="text" id="specialty" name="specialty" value="{{ old('specialty', $eatery->specialty) }}" class="form-input">
        @error('specialty')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Open checkbox.
         An unchecked checkbox is not sent at all, so the hidden input sends 0 first.
         If the box is checked, its value 1 replaces the 0. --}}
    <div class="md:col-span-2">
        <input type="hidden" name="is_open" value="0">
        <label class="inline-flex cursor-pointer items-center gap-2">
            <input type="checkbox" name="is_open" value="1" class="accent-orange-700" @checked(old('is_open', $eatery->is_open))>
            <span class="font-medium">Open (accepting reviews)</span>
        </label>
        @error('is_open')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Features checkboxes: name="features[]" sends an array of feature ids.
         After a failed submit we use what the user checked (old input),
         otherwise we check the eatery's saved features. --}}
    <div class="md:col-span-2">
        <p class="form-label">Features</p>
        <div class="flex flex-wrap gap-4">
            @foreach ($features as $feature)
                <label class="inline-flex cursor-pointer items-center gap-2">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" class="accent-orange-700"
                           @checked(session()->hasOldInput() ? in_array($feature->id, old('features', [])) : $eatery->features->contains($feature))>
                    <span>{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')
            <p class="field-error">{{ $message }}</p>
        @enderror
        @error('features.*')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Permit number --}}
    <div>
        <label for="permit_no" class="form-label">Permit number</label>
        <input type="text" id="permit_no" name="permit_no" value="{{ old('permit_no', $eatery->permit?->permit_no) }}" placeholder="DVO-2026-0904" class="form-input">
        @error('permit_no')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Permit expiry date (format Y-m-d is what <input type="date"> expects) --}}
    <div>
        <label for="expires_on" class="form-label">Permit expiry date</label>
        <input type="date" id="expires_on" name="expires_on" value="{{ old('expires_on', $eatery->permit?->expires_on->format('Y-m-d')) }}" class="form-input">
        @error('expires_on')
            <p class="field-error">{{ $message }}</p>
        @enderror
    </div>
</div>
