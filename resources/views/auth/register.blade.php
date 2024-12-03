{{-- File: resources/views/auth/register.blade.php --}}

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="max-w-2xl mx-auto p-8 rounded-lg">
        @csrf

        <x-slot name="header">
            <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
                {{ __('DAFTAR') }}
            </h2>
        </x-slot>

        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nama')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir')" required autocomplete="bday" />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="" disabled selected>{{ __('Pilih Jenis Kelamin') }}</option>
                    <option value="pria" {{ old('jenis_kelamin') == 'pria' ? 'selected' : '' }}>{{ __('Pria') }}</option>
                    <option value="wanita" {{ old('jenis_kelamin') == 'wanita' ? 'selected' : '' }}>{{ __('Wanita') }}</option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
            </div>
            
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                {{ __('Telah Mendaftar?') }}
            </a>

            <x-primary-button class="ml-4 transform transition duration-500 hover:scale-105">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>