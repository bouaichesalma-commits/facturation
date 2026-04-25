<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ __('Saved.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif
        </div>

        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profil</label>
            <div class="col-md-4 col-lg-4">
                <img src="{{ asset($user->photo) }}" alt="Profil">
                <div class="mt-2">
                    <input type="file" class="form-control" name="photo"/>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <x-input-label for="nom" :value="__('Nom')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $user->nom)" required autofocus autocomplete="nom" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('nom')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="prenom" :value="__('Prénom')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="prenom" name="prenom" type="text" class="mt-1 block w-full" :value="old('prenom', $user->prenom)" required autofocus autocomplete="prenom" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('prenom')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="text-center mt-4">
            <x-primary-button>{{ __('Modifier') }}</x-primary-button>
        </div>
    </form>
</section>
