{{-- File: resources/views/feedback/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-5xl text-green-700 leading-tight text-center">
            {{ __('Tambah Ulasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="dokter_id" class="block text-sm font-medium text-gray-700">Dokter</label>
                            <select name="dokter_id" id="dokter_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                @foreach ($dokters as $dokter)
                                    <option value="{{ $dokter->id }}">{{ $dokter->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                            <input type="number" name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="1" max="5" required>
                        </div>

                        <div class="mb-4">
                            <label for="ulasan" class="block text-sm font-medium text-gray-700">Ulasan</label>
                            <textarea name="ulasan" id="ulasan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Tambah Feedback</button>
                            <a href="{{ route('feedback.index') }}" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-lg">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>