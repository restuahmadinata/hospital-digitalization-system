{{-- File: resources/views/pasien/penjadwalan/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Jadwal Konsultasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('penjadwalan.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg">Jadwalkan Konsultasi</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Dokter</th>
                                    <th class="px-4 py-2">Tanggal Konsultasi</th>
                                    <th class="px-4 py-2">Konfirmasi</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjadwalan as $jadwal)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $jadwal->dokter->name }}</td>
                                        <td class="border px-4 py-2">{{ $jadwal->tanggal_konsultasi }}</td>
                                        <td class="border px-4 py-2">{{ $jadwal->konfirmasi }}</td>
                                        <td class="border px-4 py-2">
                                            <form action="{{ route('penjadwalan.destroy', $jadwal->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Batalkan</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $penjadwalan->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>