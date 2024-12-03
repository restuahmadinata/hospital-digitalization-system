{{-- File: resources/views/pasien/medical-record/medical-record.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Daftar Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div id="success-message" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="rounded-lg border border-gray-200">
                        <div class="overflow-x-auto rounded-t-lg">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Dokter</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Obat</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tindakan</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tanggal Berobat</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($rekamMedis as $index => $record)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $rekamMedis->firstItem() + $index }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->dokter->name }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">
                                                @foreach ($record->obats as $obat)
                                                    {{ $obat->nama_obat }}  ({{ $obat->pivot->jumlah }})<br>
                                                @endforeach
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->tindakan }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ \Carbon\Carbon::parse($record->tanggal_berobat)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $rekamMedis->links('vendor.pagination.pagination') }} <!-- Menambahkan komponen pagination -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3 detik
        }
    });
</script>