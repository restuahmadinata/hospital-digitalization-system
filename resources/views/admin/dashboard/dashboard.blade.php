{{-- File: resources/views/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Dokter yang Bertugas Hari Ini') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($dokterHariIni as $jadwal)
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h4 class="font-semibold text-lg text-gray-800">{{ $jadwal->dokter->name }}</h4>
                                <p class="text-gray-600">{{ $jadwal->dokter->email }}</p>
                                <p class="text-gray-600">{{ $jadwal->hari_tugas }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-lg">
                <div class="p-8 text-gray-900">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        {{ __('Total Pengguna Berdasarkan Peran') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($totalPengguna as $user)
                        @php
                            $roleColor = match($user->role) {
                                'admin' => 'text-red-500',
                                'pasien' => 'text-blue-500',
                                'dokter' => 'text-green-500',
                                default => 'text-gray-500',
                            };
                        @endphp
                        <div class="p-6 rounded-lg shadow-md">
                            <h4 class="font-semibold text-lg text-gray-800">{{ ucfirst($user->role) }}</h4>
                            <p class="text-5xl {{ $roleColor }}">{{ $user->total }}</p>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>