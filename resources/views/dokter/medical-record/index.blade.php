{{-- File: resources/views/medical-records/medical-record.blade.php --}}

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
                    {{ __("Daftar Rekam Medis") }}

                    @if (session('success'))
                        <div id="success-message" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('medicalrecord.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg mb-4 inline-block">Tambah Rekam Medis</a>
                    </div>

                    <div class="rounded-lg border border-gray-200">
                        <div class="overflow-x-auto rounded-t-lg">
                            <table class="min-w-full divide-y divide-gray-200 bg-white text-sm">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">No</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Pasien</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Dokter</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Penyakit</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Obat</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tindakan</th>
                                        <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Tanggal Berobat</th>                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($rekamMedis as $index => $record)
                                        <tr class="hover:bg-gray-100 cursor-pointer" onclick="showMedicalRecordModal({{ $record }})">
                                            <td class="whitespace-nowrap px-4 py-2">{{ $rekamMedis->firstItem() + $index }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->pasien->name }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->dokter->name }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->penyakit }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">
                                                @foreach ($record->obats as $obat)
                                                    {{ $obat->nama_obat }}  ({{ $obat->pivot->jumlah }})<br>
                                                @endforeach
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->tindakan }}</td>
                                            <td class="whitespace-nowrap px-4 py-2">{{ $record->tanggal_berobat->format('d M Y') }}</td>
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

    <!-- Modal -->
    <x-modal name="medical-record-modal" maxWidth="lg">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Detail Rekam Medis</h3>
            <div id="medical-record-details">
                <!-- Medical record details will be populated here -->
            </div>
            <div class="mt-4 flex space-x-4 justify-end">
                <a href="#" id="medical-record-edit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-400">Edit</a>
                <form id="delete-form-modal" action="#" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500" onclick="confirmDeletionModal()">Hapus</button>
                </form>
                <button onclick="closeModal('medical-record-modal')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500">Tutup</button>
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
    });

    function showMedicalRecordModal(record) {
        const medicalRecordDetails = document.getElementById('medical-record-details');

        let obats = '';
        record.obats.forEach(obat => {
            obats += `${obat.nama_obat} (${obat.pivot.jumlah})<br>`;
        });

        const tanggalBerobat = new Date(record.tanggal_berobat);
        const tanggal = tanggalBerobat.toLocaleDateString();
        const jam = record.tanggal_berobat.substring(11, 16);


        medicalRecordDetails.innerHTML = `
            <p><strong>Pasien:</strong> ${record.pasien.name}</p>
            <p><strong>Dokter:</strong> ${record.dokter.name}</p>
            <p><strong>Penyakit:</strong> ${record.penyakit}</p>
            <p><strong>Obat:</strong> ${obats}</p>
            <p><strong>Tindakan:</strong> ${record.tindakan}</p>
            <p><strong>Tanggal Berobat:</strong> ${tanggal}</p>

        `;

        document.getElementById('medical-record-edit').href = `/medicalrecord/${record.id}/edit`;
        document.getElementById('delete-form-modal').action = `/medicalrecord/${record.id}`;

        const userId = {{ Auth::user()->id }};
        const dokterId = record.dokter_id;

        if ({{ Auth::user()->role == 'dokter' }} && userId == dokterId) {
            document.getElementById('delete-form-modal').style.display = 'inline';
        } else {
            document.getElementById('delete-form-modal').style.display = 'none';
        }

        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'medical-record-modal' }));
    }

    function closeModal(id) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: id }));
    }

    function confirmDeletionModal() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data rekam medis yang dihapus tidak dapat dikembalikan!",
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