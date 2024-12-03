{{-- File: resources/views/pasien/dashboard/dashboard.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Tindakan Medis dan Obat yang Diberikan Dokter</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($medicalRecords as $record)
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <h4 class="text-md font-semibold mb-2">{{ $record->dokter->name }}</h4>
                                <p><strong>Tanggal Berobat:</strong> {{ $record->tanggal_berobat->format('d M Y') }}</p>
                                <p><strong>Tindakan:</strong> {{ $record->tindakan }}</p>
                                <p><strong>Obat:</strong></p>
                                <ul class="list-disc list-inside ml-4">
                                    @foreach ($record->obats as $obat)
                                        <li>{{ $obat->nama_obat }} ({{ $obat->pivot->jumlah }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Notifikasi Konsultasi Lanjutan atau Pengambilan Obat</h3>
                    <ul class="list-disc list-inside">
                        @foreach ($notifications as $notification)
                            <li>
                                <strong>Dokter:</strong> {{ $notification->dokter->name }}<br>
                                <strong>Tanggal Berobat:</strong> {{ $notification->tanggal_berobat->format('d M Y') }}<br>
                                <strong>Pesan:</strong> Silakan lakukan konsultasi lanjutan atau pengambilan obat.
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>