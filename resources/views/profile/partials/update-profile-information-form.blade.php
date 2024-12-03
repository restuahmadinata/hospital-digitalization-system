<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Anda') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Di sini anda bisa mengubah informasi profil dan alamat email") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center gap-4">
            <div class="relative">
                <img id="profile-foto" src="{{ asset($user->foto) }}" alt="Foto Profil" class="w-36 h-36 object-cover rounded-full">
                <label for="foto" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-sm font-medium rounded-full opacity-0 hover:opacity-100 cursor-pointer">
                    {{ __('Ganti Foto') }}
                </label>
                <input type="file" name="foto" id="foto" class="hidden" onchange="previewImage(event)">
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById('profile-foto');
            preview.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>