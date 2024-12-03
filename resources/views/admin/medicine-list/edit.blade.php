{{-- File: resources/views/dashboard/admin/edit-medicine.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Edit Obat') }}
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

                    <form action="{{ route('medicine.update', $obat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nama_obat" class="block text-gray-700">Nama Obat</label>
                            <input type="text" name="nama_obat" id="nama_obat" class="w-full px-4 py-2 border rounded-lg" value="{{ $obat->nama_obat }}" required>
                            @error('nama_obat')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="w-full px-4 py-2 border rounded-lg" required>{{ $obat->deskripsi }}</textarea>
                            @error('deskripsi')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="tipe_obat" class="block text-gray-700">Tipe Obat</label>
                            <select name="tipe_obat" id="tipe_obat" class="w-full px-4 py-2 border rounded-lg" required>
                                <option value="keras" {{ $obat->tipe_obat == 'keras' ? 'selected' : '' }}>Keras</option>
                                <option value="biasa" {{ $obat->tipe_obat == 'biasa' ? 'selected' : '' }}>Biasa</option>
                            </select>
                            @error('tipe_obat')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="stok" class="block text-gray-700">Stok</label>
                            <input type="number" name="stok" id="stok" class="w-full px-4 py-2 border rounded-lg" value="{{ $obat->stok }}" min="0" required>
                            @error('stok')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="gambar_obat" class="block text-gray-700">Gambar Obat</label>
                            <input type="file" name="gambar_obat" id="gambar_obat" class="w-full px-4 py-2 border rounded-lg">
                            @if ($obat->gambar_obat)
                                <img src="{{ asset($obat->gambar_obat) }}" alt="Gambar Obat" class="mt-2 w-48">
                            @endif
                            @error('gambar_obat')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kedaluwarsa" class="block text-gray-700">Tanggal Kedaluwarsa</label>
                            <input type="date" name="kedaluwarsa" id="kedaluwarsa" class="w-full px-4 py-2 border rounded-lg" value="{{ $obat->kedaluwarsa }}" required>
                            @error('kedaluwarsa')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
                            <a href="{{ route('medicine.index') }}" class="ml-4 px-5 py-3 bg-gray-600 text-white font-semibold text-sm rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-200">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>