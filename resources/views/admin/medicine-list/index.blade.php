{{-- File: resources/views/admin/medicine-list/medicine-list.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Daftar Obat') }}
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

                    <div class="mb-4">
                        <a href="{{ route('medicine.create') }}" class="font-semibold px-4 py-2 bg-green-600 text-white rounded-lg mb-4 inline-block">Tambah Obat</a>
                        <form id="filter-form" action="{{ route('medicine.index') }}" method="GET" class="flex space-x-4">
                            <div>
                                <label for="filter" class="block text-gray-700">Filter:</label>
                                <select name="filter" id="filter" class="w-36 px-4 py-2 border rounded-lg">
                                    <option value="">Semua</option>
                                    <option value="tersedia" {{ request('filter') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="tidak_tersedia" {{ request('filter') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                    <option value="kadaluarsa" {{ request('filter') == 'kadaluarsa' ? 'selected' : '' }}>Kedaluwarsa</option>
                                </select>
                            </div>
                            <div>
                                <label for="search" class="block text-gray-700">Cari Obat:</label>
                                <input type="text" name="search" id="search" class="w-64 px-4 py-2 border rounded-lg" value="{{ request('search') }}" placeholder="Cari nama obat...">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Cari</button>
                            </div>
                        </form>
                    </div>

                    <div class="rounded-lg border border-gray-200">
                        <div class="overflow-x-auto rounded-t-lg">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">No</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Gambar</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Nama Obat</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Deskripsi</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Tipe Obat</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Stok</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Tanggal Kedaluwarsa</th>
                                        <th class="whitespace-nowrap px-2 py-2 font-medium text-gray-900">Status Kedaluwarsa</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($obats as $index => $obat)
                                        <tr class="hover:bg-gray-100 cursor-pointer" onclick="showMedicineModal({{ $obat }})">
                                            <td class="whitespace-nowrap px-2 py-2">{{ $obats->firstItem() + $index }}</td>
                                            <td class="whitespace-nowrap px-2 py-2">
                                                <img src="{{ asset($obat->gambar_obat) }}" alt="Gambar Obat" class="w-16 h-16 object-cover rounded-lg">
                                            </td>
                                            <td class="whitespace-nowrap px-2 py-2">{{ $obat->nama_obat }}</td>
                                            <td class="whitespace-nowrap px-2 py-2 truncate max-w-xs">{{ $obat->deskripsi }}</td>
                                            <td class="whitespace-nowrap px-2 py-2">{{ ucfirst($obat->tipe_obat) }}</td>
                                            <td class="whitespace-nowrap px-2 py-2">{{ $obat->stok }}</td>
                                            <td class="whitespace-nowrap px-2 py-2">{{ $obat->kedaluwarsa }}</td>
                                            <td class="{{ $obat->status_kedaluwarsa == 'kedaluwarsa' ? 'bg-red-100' : 'bg-green-100' }} whitespace-nowrap px-2 py-2">{{ ucfirst($obat->status_kedaluwarsa) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $obats->appends(request()->query())->links('vendor.pagination.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="medicine-modal" maxWidth="lg">
        <div class="p-6 flex">
            <div class="w-1/3">
                <img id="medicine-image" src="" alt="Gambar Obat" class="w-full h-auto object-cover rounded-lg">
            </div>
            <div class="w-2/3 pl-6">
                <h3 class="text-2xl font-semibold mb-2" id="medicine-name"></h3>
                <p class="text-gray-700 mb-4" id="medicine-description"></p>
                <p class="text-gray-700 mb-4"><strong>Tipe Obat:</strong> <span id="medicine-type"></span></p>
                <p class="text-gray-700 mb-4"><strong>Stok:</strong> <span id="medicine-stock"></span></p>
                <p class="text-gray-700 mb-4"><strong>Tanggal Kedaluwarsa:</strong> <span id="medicine-expiry"></span></p>
                <p class="text-gray-700 mb-4"><strong>Status Kedaluwarsa:</strong> <span id="medicine-status"></span></p>
                <div class="flex space-x-4">
                    <a href="#" id="medicine-edit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-400">Edit</a>
                    <form id="delete-form-modal" action="#" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500" onclick="confirmDeletionModal()">Hapus</button>
                    </form>
                    <button onclick="closeModal('medicine-modal')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500">Tutup</button>
                </div>
            </div>
        </div>
    </x-modal>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelect = document.getElementById('filter');
        filterSelect.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3 detik
        }
    });

    function showMedicineModal(obat) {
        document.getElementById('medicine-image').src = `{{ asset('${obat.gambar_obat}') }}`;
        document.getElementById('medicine-name').innerText = obat.nama_obat;
        document.getElementById('medicine-description').innerText = obat.deskripsi;
        document.getElementById('medicine-type').innerText = obat.tipe_obat.charAt(0).toUpperCase() + obat.tipe_obat.slice(1);
        document.getElementById('medicine-stock').innerText = obat.stok;
        document.getElementById('medicine-expiry').innerText = obat.kedaluwarsa;
        document.getElementById('medicine-status').innerText = obat.status_kedaluwarsa.charAt(0).toUpperCase() + obat.status_kedaluwarsa.slice(1);
        document.getElementById('medicine-edit').href = `{{ url('medicine/${obat.id}/edit') }}`;
        document.getElementById('delete-form-modal').action = `{{ url('medicine/${obat.id}') }}`;

        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'medicine-modal' }));
    }

    function closeModal(id) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: id }));
    }

    function confirmDeletionModal() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data obat yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-modal').submit();
            }
        });
    }
</script>