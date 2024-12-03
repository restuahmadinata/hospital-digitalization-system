{{-- File: resources/views/admin/user-list/user-list.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Daftar User') }}
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
                        <a href="{{ route('user.create') }}" class="font-semibold px-4 py-2 bg-green-600 text-white rounded-lg mb-4 inline-block">Tambah User</a>
                    </div>

                    <div class="mb-4 flex space-x-4">
                        <div>
                            <label for="filter-role" class="block text-sm font-medium text-gray-700">Filter Peran</label>
                            <select id="filter-role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Semua Peran</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="pasien" {{ request('role') == 'pasien' ? 'selected' : '' }}>Pasien</option>
                                <option value="dokter" {{ request('role') == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            </select>
                        </div>
                        <div>
                            <label for="filter-date" class="block text-sm font-medium text-gray-700">Filter Tanggal Registrasi</label>
                            <input type="date" id="filter-date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ request('date') }}">
                        </div>
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Cari</label>
                            <input type="text" id="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ request('search') }}" placeholder="Cari nama atau email">
                        </div>
                    </div>

                    <div class="rounded-lg border border-gray-200">
                        <div class="overflow-x-auto rounded-t-lg">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-md text-center">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Foto</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tanggal Lahir</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Jenis Kelamin</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Peran</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tanggal Registrasi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($users as $index => $user)
                                        <tr class="hover:bg-gray-100 cursor-pointer" onclick="showUserModal({{ $user }})">
                                            <td class="whitespace-nowrap px-4 py-2">{{ $users->firstItem() + $index }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">
                                                <img src="{{ asset($user->foto) }}" alt="Foto Profil" class="w-12 h-12 object-cover rounded-full">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $user->name }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $user->email }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $user->tanggal_lahir }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $user->jenis_kelamin }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $user->role }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->appends(request()->query())->links('pagination::pagination') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="user-modal" maxWidth="md">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Detail User</h3>
            <div class="flex items-center mb-4">
                <img id="user-foto" src="" alt="Foto Profil" class="w-36 h-36 object-cover rounded-lg mr-4">
                <div id="user-details">
                    <!-- User details will be populated here -->
                </div>
            </div>
            <div class="mt-4 flex space-x-4 justify-end">
                <a href="#" id="user-edit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-400">Edit</a>
                <form id="delete-form-modal" action="#" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="delete-button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500" onclick="confirmDeletionModal()">Hapus</button>
                </form>
                <button onclick="closeModal('user-modal')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500">Tutup</button>
            </div>
        </div>
    </x-modal>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000); // 3 detik
        }

        const filterRole = document.getElementById('filter-role');
        const filterDate = document.getElementById('filter-date');
        const searchInput = document.getElementById('search');

        filterRole.addEventListener('change', applyFilters);
        filterDate.addEventListener('change', applyFilters);
        searchInput.addEventListener('input', applyFilters);

        function applyFilters() {
            const role = filterRole.value;
            const date = filterDate.value;
            const search = searchInput.value;
            const url = new URL(window.location.href);
            if (role) {
                url.searchParams.set('role', role);
            } else {
                url.searchParams.delete('role');
            }
            if (date) {
                url.searchParams.set('date', date);
            } else {
                url.searchParams.delete('date');
            }
            if (search) {
                url.searchParams.set('search', search);
            } else {
                url.searchParams.delete('search');
            }
            url.searchParams.delete('page'); // Reset page to 1
            window.location.href = url.toString();
        }
    });

    function showUserModal(user) {
        const userDetails = document.getElementById('user-details');
        const userFoto = document.getElementById('user-foto');
        const deleteButton = document.getElementById('delete-button');

        userDetails.innerHTML = `
            <p><strong>Nama:</strong> ${user.name}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Tanggal Lahir:</strong> ${user.tanggal_lahir}</p>
            <p><strong>Jenis Kelamin:</strong> ${user.jenis_kelamin}</p>
            <p><strong>Peran:</strong> ${user.role}</p>
            <p><strong>Tanggal Registrasi:</strong> ${new Date(user.created_at).toLocaleDateString()}</p>
        `;

        userFoto.src = `{{ asset('${user.foto}') }}`;

        document.getElementById('user-edit').href = `{{ route('user.edit', ':id') }}`.replace(':id', user.id);
        document.getElementById('delete-form-modal').action = `{{ url('user/${user.id}') }}`;

        // Hide delete button if user is admin with id 1
        if (user.id === 1) {
            deleteButton.style.display = 'none';
        } else {
            deleteButton.style.display = 'inline-block';
        }

        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'user-modal' }));
    }

    function closeModal(id) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: id }));
    }

    function confirmDeletion(userId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pengguna yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        });
    }

    function confirmDeletionModal() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pengguna yang dihapus tidak dapat dikembalikan!",
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