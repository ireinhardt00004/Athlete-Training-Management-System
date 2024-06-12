<section>
    <header>
        <h2 class="text-lg font-medium" style="text-transform: uppercase; color: blue !important;">
            <b>Profile Information</b>
        </h2>

        <p class="mt-1 text-sm text-black-600">
            Update your account's profile information and email address.
        </p>
    </header>

    {{-- <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>--}}

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="mb-3">
            <label for="profile_pic" class="form-label">Profile Photo</label>
            <input name="profile_pic" type="file" class="form-control @error('profile_pic') is-invalid @enderror" accept="image/*">
            @error('profile_pic')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="lname" class="form-label">Last Name</label>
            <input id="lname" name="lname" type="text" class="form-control" value="{{ old('lname', $user->lname) }}" required autofocus autocomplete="name">
            @error('lname')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="middlename" class="form-label">Middle Name</label>
            <input id="middlename" name="middlename" type="text" class="form-control" value="{{ old('middlename', $user->middlename) }}" required autofocus autocomplete="name">
            @error('middlename')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="fname" class="form-label">First Name</label>
            <input id="fname" name="fname" type="text" class="form-control" value="{{ old('fname', $user->fname) }}" required autofocus autocomplete="name">
            @error('fname')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Your email address is unverified.
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >Saved.</p>
            @endif
        </div>
    </form>
</section>
