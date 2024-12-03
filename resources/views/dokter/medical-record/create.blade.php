{{-- File: resources/views/medical-records/create-record.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Tambah Rekam Medis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Tambah Rekam Medis") }}

                    @if ($errors->any())
                        <div class="mb-4">
                            <div class="font-medium text-red-600">Ada kesalahan pada input Anda:</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('medicalrecord.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Pasien -->
                            <div>
                                <label for="pasien_id" class="block text-sm font-medium text-gray-700">Pasien</label>
                                <select name="pasien_id" id="pasien_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="" disabled selected>Pilih Pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>{{ $pasien->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Dokter -->
                            <div>
                                <label for="dokter_id" class="block text-sm font-medium text-gray-700">Dokter</label>
                                <select name="dokter_id" id="dokter_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="" disabled selected>Pilih Dokter</option>
                                    @foreach ($dokters as $dokter)
                                        <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>{{ $dokter->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Penyakit -->
                            <div>
                                <label for="penyakit" class="block text-sm font-medium text-gray-700">Penyakit</label>
                                <input type="text" name="penyakit" id="penyakit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('penyakit') }}" required>
                            </div>

                            <!-- Tindakan Medis -->
                            <div>
                                <label for="tindakan" class="block text-sm font-medium text-gray-700">Tindakan Medis</label>
                                <textarea name="tindakan" id="tindakan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('tindakan') }}</textarea>
                            </div>

                            <!-- Tanggal Berobat -->
                            <div>
                                <label for="tanggal_berobat" class="block text-sm font-medium text-gray-700">Tanggal Berobat</label>
                                <input type="date" name="tanggal_berobat" id="tanggal_berobat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('tanggal_berobat') }}" required>
                            </div>

                            <!-- Obat -->
                            <div id="obat-container" class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Obat</label>
                                <div class="obat-item flex space-x-4 mt-2">
                                    <select name="obat_id[]" class="obat-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="" disabled selected>Pilih Obat</option>
                                        @foreach ($obats as $obat)
                                            <option value="{{ $obat->id }}" {{ collect(old('obat_id'))->contains($obat->id) ? 'selected' : '' }}>{{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="jumlah_obat[]" class="jumlah-obat mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="1" placeholder="Jumlah" required>
                                    <button type="button" class="remove-obat btn btn-danger mt-2 text-red-600 hover:text-red-800">Hapus</button>
                                </div>
                            </div>
                            <button type="button" id="add-obat" class="btn btn-primary mt-4 bg-blue-500 text-white rounded-lg px-4 py-2 w-36 hover:bg-blue-700">Tambah Obat</button>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                Tambah Rekam Medis
                            </button>
                            <a href="{{ route('medicalrecord.index') }}" class="ml-4 px-4 py-2 bg-gray-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
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
        const addObatButton = document.getElementById('add-obat');
        const obatContainer = document.getElementById('obat-container');
        const availableObats = @json($obats);

        function updateObatOptions() {
            const selectedObatIds = Array.from(document.querySelectorAll('.obat-select')).map(select => select.value);
            document.querySelectorAll('.obat-select').forEach(select => {
                const currentValue = select.value;
                select.innerHTML = '<option value="" disabled>Pilih Obat</option>';
                availableObats.forEach(obat => {
                    if (!selectedObatIds.includes(obat.id.toString()) || obat.id.toString() === currentValue) {
                        select.innerHTML += `<option value="${obat.id}" ${obat.id.toString() === currentValue ? 'selected' : ''}>${obat.nama_obat} (Stok: ${obat.stok})</option>`;
                    }
                });
            });
        }

        function validateJumlahObat() {
            document.querySelectorAll('.jumlah-obat').forEach(input => {
                const select = input.closest('.obat-item').querySelector('.obat-select');
                const obatId = select.value;
                const obat = availableObats.find(o => o.id == obatId);
                if (obat && input.value > obat.stok) {
                    input.setCustomValidity('Jumlah obat melebihi stok yang tersedia.');
                } else {
                    input.setCustomValidity('');
                }
            });
        }

        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-obat');
            if (removeButtons.length > 1) {
                removeButtons.forEach(button => button.style.display = 'inline-block');
            } else {
                removeButtons.forEach(button => button.style.display = 'none');
            }
        }

        addObatButton.addEventListener('click', function() {
            const obatItem = document.createElement('div');
            obatItem.classList.add('obat-item', 'flex', 'space-x-4', 'mt-2');
            obatItem.innerHTML = `
                <select name="obat_id[]" class="obat-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="" disabled selected>Pilih Obat</option>
                </select>
                <input type="number" name="jumlah_obat[]" class="jumlah-obat mt-1 block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="1" placeholder="Jumlah" required>
                <button type="button" class="remove-obat btn btn-danger mt-2 text-red-600 hover:text-red-800">Hapus</button>
            `;
            obatContainer.appendChild(obatItem);

            updateObatOptions();
            updateRemoveButtons();

            obatItem.querySelector('.remove-obat').addEventListener('click', function() {
                obatItem.remove();
                updateObatOptions();
                updateRemoveButtons();
            });

            obatItem.querySelector('.jumlah-obat').addEventListener('input', validateJumlahObat);
        });

        document.querySelectorAll('.remove-obat').forEach(button => {
            button.addEventListener('click', function() {
                button.parentElement.remove();
                updateObatOptions();
                updateRemoveButtons();
            });
        });

        document.querySelectorAll('.jumlah-obat').forEach(input => {
            input.addEventListener('input', validateJumlahObat);
        });

        updateObatOptions();
        updateRemoveButtons();
    });
</script>