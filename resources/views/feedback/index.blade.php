{{-- File: resources/views/feedback/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Ulasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div id="success-message" class="mb-4 px-4 py-2 bg-green-500 text-white rounded-lg transition-opacity duration-500 ease-in-out">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div id="error-message" class="mb-4 px-4 py-2 bg-red-500 text-white rounded-lg transition-opacity duration-500 ease-in-out">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        @if (Auth::user()->role == 'pasien')
                            <a href="{{ route('feedback.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg mb-4 inline-block font-semibold">Tambah Ulasan</a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Dokter</th>
                                    <th class="px-4 py-2">Rating</th>
                                    <th class="px-4 py-2">Ulasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedbacks as $feedback)
                                    <tr class="hover:bg-gray-100 cursor-pointer" onclick="showFeedbackModal({{ $feedback }})">
                                        <td class="border px-4 py-2">{{ $feedback->dokter->name }}</td>
                                        <td class="border px-4 py-2">
                                            @for ($i = 0; $i < $feedback->rating; $i++)
                                                ★
                                            @endfor
                                            @for ($i = $feedback->rating; $i < 5; $i++)
                                                ☆
                                            @endfor
                                        </td>
                                        <td class="border px-4 py-2">{{ $feedback->ulasan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $feedbacks->links('vendor.pagination.pagination') }} <!-- Menambahkan komponen pagination -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="feedback-modal" maxWidth="lg">
        <div class="p-6">
            <h3 class="text-xl font-semibold mb-4">Detail Feedback</h3>
            <div id="feedback-details">
                <!-- Feedback details will be populated here -->
            </div>
            <div class="mt-4 flex space-x-4 justify-end">
                <a href="#" id="feedback-edit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-400">Edit</a>
                <form id="delete-form-modal" action="#" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500" onclick="confirmDeletionModal()">Hapus</button>
                </form>
                <button onclick="closeModal('feedback-modal')" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500">Tutup</button>
            </div>
        </div>
    </x-modal>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        if (successMessage) {
            setTimeout(() => {
                successMessage.classList.add('opacity-0');
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 500); // Durasi animasi
            }, 3000); // 3 detik
        }

        if (errorMessage) {
            setTimeout(() => {
                errorMessage.classList.add('opacity-0');
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 500); // Durasi animasi
            }, 3000); // 3 detik
        }
    });

    function showFeedbackModal(feedback) {
        const feedbackDetails = document.getElementById('feedback-details');

        let ratingStars = '';
        for (let i = 0; i < feedback.rating; i++) {
            ratingStars += '★';
        }
        for (let i = feedback.rating; i < 5; i++) {
            ratingStars += '☆';
        }

        feedbackDetails.innerHTML = `
            <p><strong>Dokter:</strong> ${feedback.dokter.name}</p>
            <p><strong>Rating:</strong> ${ratingStars}</p>
            <p><strong>Ulasan:</strong> ${feedback.ulasan}</p>
        `;

        document.getElementById('feedback-edit').href = `/feedback/${feedback.id}/edit`;
        document.getElementById('delete-form-modal').action = `/feedback/${feedback.id}`;

        const userId = {{ Auth::user()->id }};
        const pasienId = feedback.pasien_id;

        if ({{ Auth::user()->role == 'pasien' }} && userId == pasienId) {
            document.getElementById('feedback-edit').style.display = 'inline';
            document.getElementById('delete-form-modal').style.display = 'inline';
        } else {
            document.getElementById('feedback-edit').style.display = 'none';
            document.getElementById('delete-form-modal').style.display = 'none';
        }

        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'feedback-modal' }));
    }

    function closeModal(id) {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: id }));
    }

    function confirmDeletionModal() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data feedback yang dihapus tidak dapat dikembalikan!",
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