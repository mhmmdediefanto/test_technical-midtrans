<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Welcome</title>
</head>

<body class="bg-gradient-to-br from-cyan-300">
    <div class="h-screen flex flex-col justify-center items-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4 text-center">Selamat Datang di Rental PlayStation</h1>
        <p class="text-gray-600 text-lg mb-6 text-center">
            Nikmati pengalaman bermain game terbaik dengan harga terjangkau! Pilih layanan rental PS4 atau PS5 dan pesan
            sekarang.
        </p>

        <!-- Gambar PS4 & PS5 -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- PS4 -->
            <div class="border p-4 rounded-lg shadow-md text-center bg-white">
                <img src="https://images.unsplash.com/photo-1507457379470-08b800bebc67?q=80&w=2109&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="PS4" class="w-48 mx-auto">
                <h2 class="text-xl font-bold mt-2">PlayStation 4</h2>
                <p class="text-gray-600">Harga: Rp 30.000 per sesi</p>
            </div>

            <!-- PS5 -->
            <div class="border p-4 rounded-lg shadow-md text-center bg-white">
                <img src="https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="PS5" class="w-48 mx-auto">
                <h2 class="text-xl font-bold mt-2">PlayStation 5</h2>
                <p class="text-gray-600">Harga: Rp 40.000 per sesi</p>
            </div>
        </div>

        <!-- Tombol Mulai Booking -->
        <a href="{{ route('booking') }}"
            class="mt-6 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition duration-300">
            Mulai Booking
        </a>
    </div>
</body>

</html>
