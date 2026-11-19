{{-- error summary, shared by the eatery form and the review form --}}
@if ($errors->any())
    <div class="alert-error">
        <p class="font-semibold">Please fix the following errors:</p>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
