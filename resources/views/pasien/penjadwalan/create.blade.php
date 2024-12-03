{{-- File: resources/views/pasien/penjadwalan/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Jadwalkan Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('penjadwalan.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="id_dokter" class="block text-sm font-medium text-gray-700">Dokter</label>
                            <select name="id_dokter" id="id_dokter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                <option value="" disabled selected>Pilih Dokter</option>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tanggal_konsultasi" class="block text-sm font-medium text-gray-700">Tanggal Konsultasi</label>
                            <input type="date" name="tanggal_konsultasi" id="tanggal_konsultasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Jadwal Dokter</label>
                            <ul id="jadwal-dokter" class="list-disc list-inside ml-4 text-sm text-gray-600"></ul>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                                Jadwalkan Konsultasi
                            </button>
                            <a href="{{ route('penjadwalan.index') }}" class="ml-4 px-4 py-2 bg-gray-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dokterSelect = document.getElementById('id_dokter');
        const jadwalDokterList = document.getElementById('jadwal-dokter');

        dokterSelect.addEventListener('change', function() {
            const dokterId = this.value;
            if (dokterId) {
                fetch(`/penjadwalan/jadwal-dokter/${dokterId}`)
                    .then(response => response.json())
                    .then(data => {
                        jadwalDokterList.innerHTML = '';
                        data.forEach(jadwal => {
                            const listItem = document.createElement('li');
                            listItem.textContent = jadwal.hari_tugas;
                            jadwalDokterList.appendChild(listItem);
                        });
                    });
            } else {
                jadwalDokterList.innerHTML = '';
            }
        });
    });
</script>