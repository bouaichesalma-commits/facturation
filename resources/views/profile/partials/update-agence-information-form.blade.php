<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.updateagence') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            @if (session('status') === 'agence-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ __('Saved.') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
{{-- 'storage/images/'. --}}
        <div class="row mb-3">
            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Logo</label>
            <div class="col-md-4 col-lg-4">
                <img src="{{ asset($agence->logo) }}" alt="Logo">
                <div class="mt-2">
                    <input type="file" class="form-control" name="logo"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="signature" class="col-md-4 col-lg-3 col-form-label">signature</label>
            <div class="col-md-4 col-lg-4">
                <img src="{{ asset($agence->signature) }}" alt="signature">
                <div class="mt-2">
                    <input type="file" class="form-control" name="signature"/>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <label for="cachet" class="col-md-4 col-lg-3 col-form-label">cachet</label>
            <div class="col-md-4 col-lg-4">
                <img src="{{ asset($agence->cachet) }}" alt="cachet">
                <div class="mt-2">
                    <input type="file" class="form-control" name="cachet"/>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <x-input-label for="nom" :value="__('Nom')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="nom" name="nom" type="text" class="mt-1 block w-full" :value="old('nom', $agence->nom)" autofocus autocomplete="nom" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('nom')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="adresse" :value="__('Adresse')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="adresse" name="adresse" type="text" class="mt-1 block w-full" :value="old('adresse', $agence->adresse)" required autofocus autocomplete="adresse" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('adresse')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="gsm" :value="__('GSM')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="gsm" name="gsm" type="tel" class="mt-1 block w-full" :value="old('gsm', $agence->gsm)" required autofocus autocomplete="gsm" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('gsm')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="fixe" :value="__('Fixe')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="fixe" name="fixe" type="tel" class="mt-1 block w-full" :value="old('fixe', $agence->fixe)" required autofocus autocomplete="fixe" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('fixe')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="email" :value="__('Email')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $agence->email)" required autofocus autocomplete="email" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="site" :value="__('Site')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="site" name="site" type="text" class="mt-1 block w-full" :value="old('site', $agence->site)" required autofocus autocomplete="site" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('site')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="ice" :value="__('ICE')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="ice" name="ice" type="number" class="mt-1 block w-full" :value="old('ice', $agence->ice)" required autofocus autocomplete="ice" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('ice')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="compte" :value="__('Compte')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="compte" name="compte" type="text" class="mt-1 block w-full" :value="old('compte', $agence->compte)" required autofocus autocomplete="compte" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('compte')" />
        </div>
        <div class="row mb-3">
    <x-input-label for="banque" :value="__('Banque')" />
    <div class="col-md-8 col-lg-9">
        <x-text-input id="banque" name="banque" type="text" class="mt-1 block w-full" :value="old('banque', $agence->banque)" required autofocus autocomplete="banque" />
    </div>
    <x-input-error class="mt-2" :messages="$errors->get('banque')" />
</div>


        <div class="row mb-3">
            <x-input-label for="capital" :value="__('Capital')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="capital" name="capital" type="number" class="mt-1 block w-full" :value="old('capital', $agence->capital)" required autofocus autocomplete="capital" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('capital')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="rc" :value="__('RC')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="rc" name="rc" type="number" class="mt-1 block w-full" :value="old('rc', $agence->rc)" required autofocus autocomplete="rc" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('rc')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="if" :value="__('IF')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="if" name="if" type="number" class="mt-1 block w-full" :value="old('if', $agence->if)" required autofocus autocomplete="if" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('if')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="tp" :value="__('TP')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="tp" name="tp" type="number" class="mt-1 block w-full" :value="old('tp', $agence->tp)" required autofocus autocomplete="tp" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('tp')" />
        </div>

        <div class="row mb-3">
            <x-input-label for="cnss" :value="__('CNSS')" />
            <div class="col-md-8 col-lg-9">
                <x-text-input id="cnss" name="cnss" type="number" class="mt-1 block w-full" :value="old('cnss', $agence->cnss)" required autofocus autocomplete="cnss" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('cnss')" />
        </div>


        <div class="text-center mt-4">
            <x-primary-button>{{ __('Modifier') }}</x-primary-button>
        </div>
    </form>
</section>
