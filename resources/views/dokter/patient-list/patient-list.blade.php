{{-- File: resources/views/dokter/patient-list/patient-list.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Daftar Pasien yang Pernah Ditangani') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Daftar Pasien yang Pernah Ditangani") }}

                    @if (session('success'))
                        <div id="success-message" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <form action="{{ route('patientlist') }}" method="GET">
                            <label for="search" class="block text-gray-700">Cari Pasien:</label>
                            <input type="text" name="search" id="search" class="w-full px-4 py-2 border rounded-lg" value="{{ request('search') }}">
                        </form>
                    </div>

                    <div class="rounded-lg border border-gray-200">
                        <div class="overflow-x-auto rounded-t-lg">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama Pasien</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($patients as $index => $record)
                                        <tr>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $patients->firstItem() + $index }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->pasien->name }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->pasien->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $patients->links('vendor.pagination.pagination') }} <!-- Menambahkan komponen pagination -->
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