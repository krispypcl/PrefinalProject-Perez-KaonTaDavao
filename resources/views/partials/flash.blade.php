{{-- shows the message sent with ->with('success', '...') in the controller --}}
@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif
