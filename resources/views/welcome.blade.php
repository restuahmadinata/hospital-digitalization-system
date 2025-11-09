<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rumah Sakit Sehat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* subtle dark overlay for hero text readability */
        .hero-overlay { background: linear-gradient(180deg, rgba(0,0,0,0.35), rgba(0,0,0,0.25)); }
    </style>
</head>

<body class="antialiased text-gray-800 bg-gray-50">

    <!-- HERO with background image -->
    <header class="relative h-screen max-h-[720px] flex items-center">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1533042789716-e9a9c97cf4ee?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2069');"></div>
        <div class="absolute inset-0 hero-overlay"></div>

        <div class="container mx-auto relative z-10 px-6 text-white">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight drop-shadow">Rumah Sakit Sehat</h1>
                <p class="mt-4 text-lg md:text-xl text-gray-100/90">Pelayanan kesehatan modern, tenaga medis profesional, dan perhatian penuh untuk setiap pasien.</p>

                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <a href="/login" class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow">Login</a>
                    <a href="/register" class="inline-flex items-center justify-center bg-white/90 hover:bg-white text-green-800 font-semibold px-6 py-3 rounded-lg shadow">Daftar</a>
                </div>
            </div>
        </div>
    </header>

    <main class="-mt-20 relative z-20">
        <div class="container mx-auto px-6">
            <!-- Features cards -->
            <section class="bg-white rounded-xl shadow-lg -mt-10 p-6 md:p-10">
                <h2 class="text-2xl font-bold text-gray-800">Mengapa Memilih Kami?</h2>
                <p class="mt-2 text-gray-600 max-w-2xl">Kami menggabungkan teknologi dan keahlian medis untuk memberikan diagnosis dan perawatan yang cepat dan tepat.</p>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex flex-col bg-gray-50 rounded-lg p-5">
                        <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2068" alt="Fasilitas modern" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="font-semibold text-lg">Fasilitas Modern</h3>
                        <p class="text-sm text-gray-600 mt-2">Peralatan diagnostik dan perawatan terbaru untuk kenyamanan dan akurasi.</p>
                    </div>

                    <div class="flex flex-col bg-gray-50 rounded-lg p-5">
                        <img src="https://plus.unsplash.com/premium_photo-1681843126728-04eab730febe?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2070" alt="Dokter profesional" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="font-semibold text-lg">Dokter Profesional</h3>
                        <p class="text-sm text-gray-600 mt-2">Tim dokter berpengalaman dari berbagai spesialisasi siap membantu Anda.</p>
                    </div>

                    <div class="flex flex-col bg-gray-50 rounded-lg p-5">
                        <img src="https://plus.unsplash.com/premium_photo-1673988726931-127584121c34?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=1964" alt="Pelayanan 24/7" class="w-full h-40 object-cover rounded-md mb-4">
                        <h3 class="font-semibold text-lg">Pelayanan 24/7</h3>
                        <p class="text-sm text-gray-600 mt-2">Unit gawat darurat dan layanan darurat siap 24 jam sehari, 7 hari seminggu.</p>
                    </div>
                </div>
            </section>

            <!-- Doctors showcase -->
            <section class="mt-8">
                <h2 class="text-2xl font-bold">Tim Dokter Kami</h2>
                <p class="text-gray-600 mt-1">Beberapa dari spesialis kami yang siap merawat Anda.</p>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <img src="https://plus.unsplash.com/premium_photo-1658506671316-0b293df7c72b?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2070" alt="Dokter" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold">Dr. Andi Prasetyo</h3>
                            <p class="text-sm text-gray-500">Spesialis Penyakit Dalam</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2070" alt="Dokter" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold">Dr. Siti Rahma</h3>
                            <p class="text-sm text-gray-500">Spesialis Kebidanan & Kandungan</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2070" alt="Dokter" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold">Dr. Budi Santoso</h3>
                            <p class="text-sm text-gray-500">Dokter Bedah</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1673865641073-4479f93a7776?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=2070" alt="Dokter" class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="font-semibold">Dr. Maya Lestari</h3>
                            <p class="text-sm text-gray-500">Spesialis Anak</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA -->
            <section class="mt-12 bg-gradient-to-r from-green-600 to-teal-500 text-white rounded-xl p-8 flex flex-col md:flex-row items-center gap-6">
                <div class="flex-1">
                    <h3 class="text-2xl font-bold">Butuh Bantuan Medis?</h3>
                    <p class="mt-2 text-white/90">Hubungi kami sekarang untuk konsultasi atau jadwalkan kunjungan Anda.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="tel:+62211234567" class="bg-white text-green-700 font-semibold px-5 py-3 rounded-lg shadow">Telepon</a>
                    <a href="https://wa.me/6287723390480" target="_blank" class="bg-white/90 text-green-800 font-semibold px-5 py-3 rounded-lg shadow">WhatsApp</a>
                </div>
            </section>

            <!-- Contact / Footer info -->
            <footer class="mt-12 mb-12 text-sm text-gray-600">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                    <div>
                        <h4 class="font-semibold text-gray-800">Rumah Sakit Sehat</h4>
                        <p class="mt-1">Jl. Sehat No.123, Jakarta, Indonesia</p>
                        <p class="mt-1">Tel: (021) 123-4567 | Email: info@rumahsakitsehat.com</p>
                    </div>
                    <div class="text-right md:text-left">
                        <p>© 2024 Rumah Sakit Sehat. Semua Hak Dilindungi.</p>
                        <p class="mt-1">Ikuti kami di: <a href="#" class="text-green-600">Facebook</a> · <a href="#" class="text-green-600">Instagram</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </main>

</body>

</html>
