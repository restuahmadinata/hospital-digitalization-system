{{-- File: resources/views/dashboard/admin/create-user.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Tambah Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" name="username" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('username') }}" required>
                                @error('username')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('tanggal_lahir') }}" max="{{ now()->toDateString() }}" required>
                                @error('tanggal_lahir')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="pria" {{ old('jenis_kelamin') == 'pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="wanita" {{ old('jenis_kelamin') == 'wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
                                @error('jenis_kelamin')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pasien" {{ old('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                                    <option value="dokter" {{ old('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                                </select>
                                @error('role')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Jenis Dokter -->
                            <div id="jenis-dokter-container" class="hidden">
                                <label for="jenis_dokter" class="block text-sm font-medium text-gray-700">Jenis Dokter</label>
                                <select name="jenis_dokter" id="jenis_dokter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" disabled selected>Pilih Jenis Dokter</option>
                                    <option value="umum" {{ old('jenis_dokter') == 'umum' ? 'selected' : '' }}>Umum</option>
                                    <option value="spesialis" {{ old('jenis_dokter') == 'spesialis' ? 'selected' : '' }}>Spesialis</option>
                                </select>
                                @error('jenis_dokter')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Spesialisasi Dokter -->
                            <div id="spesialisasi-container" class="hidden">
                                <label for="spesialisasi" class="block text-sm font-medium text-gray-700">Spesialisasi</label>
                                <select name="spesialisasi" id="spesialisasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="" disabled selected>Pilih Spesialisasi</option>
                                    <option value="Interna (Internis)" {{ old('spesialisasi') == 'Interna (Internis)' ? 'selected' : '' }}>Interna (Internis)</option>
                                    <option value="Pediatri (Pediatrisian)" {{ old('spesialisasi') == 'Pediatri (Pediatrisian)' ? 'selected' : '' }}>Pediatri (Pediatrisian)</option>
                                    <option value="Obstetri dan Ginekologi (OB/GYN)" {{ old('spesialisasi') == 'Obstetri dan Ginekologi (OB/GYN)' ? 'selected' : '' }}>Obstetri dan Ginekologi (OB/GYN)</option>
                                    <option value="Bedah Umum (General Surgeon)" {{ old('spesialisasi') == 'Bedah Umum (General Surgeon)' ? 'selected' : '' }}>Bedah Umum (General Surgeon)</option>
                                    <option value="Anestesiologi (Anestesiolog)" {{ old('spesialisasi') == 'Anestesiologi (Anestesiolog)' ? 'selected' : '' }}>Anestesiologi (Anestesiolog)</option>
                                </select>
                                @error('spesialisasi')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Hari Tugas -->
                            <div id="hari-tugas-container" class="hidden">
                                <label for="hari_tugas" class="block text-sm font-medium text-gray-700">Hari Tugas</label>
                                <div class="flex flex-wrap">
                                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                        <div class="mr-4">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="hari_tugas[]" value="{{ $hari }}" class="form-checkbox" {{ in_array($hari, old('hari_tugas', [])) ? 'checked' : '' }}>
                                                <span class="ml-2">{{ $hari }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('hari_tugas')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Foto -->
                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                                <input type="file" name="foto" id="foto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @error('foto')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @error('password')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @error('password_confirmation')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                                Tambah Pengguna
                            </button>
                            <a href="{{ route('user.index') }}" class="ml-4 px-4 py-2 bg-gray-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
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
        const roleSelect = document.getElementById('role');
        const jenisDokterContainer = document.getElementById('jenis-dokter-container');
        const spesialisasiContainer = document.getElementById('spesialisasi-container');
        const hariTugasContainer = document.getElementById('hari-tugas-container');
        const jenisDokterSelect = document.getElementById('jenis_dokter');
        const spesialisasiSelect = document.getElementById('spesialisasi');

        roleSelect.addEventListener('change', function() {
            if (this.value === 'dokter') {
                jenisDokterContainer.classList.remove('hidden');
                hariTugasContainer.classList.remove('hidden');
            } else {
                jenisDokterContainer.classList.add('hidden');
                spesialisasiContainer.classList.add('hidden');
                hariTugasContainer.classList.add('hidden');
                // Reset selects when hiding
                jenisDokterSelect.value = '';
                spesialisasiSelect.value = '';
            }
        });

        jenisDokterSelect.addEventListener('change', function() {
            if (this.value === 'spesialis') {
                spesialisasiContainer.classList.remove('hidden');
                // Make spesialisasi required when dokter is spesialis
                spesialisasiSelect.setAttribute('required', 'required');
            } else {
                spesialisasiContainer.classList.add('hidden');
                spesialisasiSelect.value = ''; // Clear spesialisasi input
                // Remove required when dokter is umum
                spesialisasiSelect.removeAttribute('required');
            }
        });

        // Trigger change event on page load to handle old input
        roleSelect.dispatchEvent(new Event('change'));
        jenisDokterSelect.dispatchEvent(new Event('change'));
    });
</script>