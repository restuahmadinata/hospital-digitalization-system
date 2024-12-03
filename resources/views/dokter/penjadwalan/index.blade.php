{{-- File: resources/views/dokter/penjadwalan/index.blade.php --}}

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

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Pasien</th>
                                    <th class="px-4 py-2">Tanggal Konsultasi</th>
                                    <th class="px-4 py-2">Konfirmasi</th>
                                    <th class="px-4 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penjadwalan as $jadwal)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $jadwal->pasien->name }}</td>
                                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($jadwal->tanggal_konsultasi)->translatedFormat('d F Y') }}</td>
                                        <td class="border px-4 py-2">{{ $jadwal->konfirmasi }}</td>
                                        <td class="border px-4 py-2">
                                            @if ($jadwal->konfirmasi == 'tidak')
                                                <form action="{{ route('penjadwalan.approve', $jadwal->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Setujui</button>
                                                </form>
                                            @endif
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