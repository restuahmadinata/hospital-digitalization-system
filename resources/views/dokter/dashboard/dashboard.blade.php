{{-- File: resources/views/dokter/dashboard/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Dashboard Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Pasien Terbaru yang Telah Diperiksa</h3>
                    <ul class="list-disc list-inside">
                        @foreach ($latestPatients as $record)
                            <li>{{ $record->pasien->name }} - {{ \Carbon\Carbon::parse($record->tanggal_berobat)->format('d M Y') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Rekam Medis yang Sedang Diproses</h3>
                    <ul class="list-disc list-inside">
                        @foreach ($ongoingRecords as $record)
                            <li>
                                <a href="{{ route('medicalrecord.edit', $record->id) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $record->pasien->name }} - {{ \Carbon\Carbon::parse($record->tanggal_berobat)->format('d M Y') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>