<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>

<body class="bg-gradient-to-tr from-white to-cyan-300">
    <div class="w-full flex items-center justify-center bg-white p-3">
        <div class="w-1/2 flex justify-around">
            <a href="{{ route('history') }}" class="text-gray-600 hover:text-gray-800">History Booking</a>
          
        </div>
    </div>
    <div class="w-1/2 mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">



        @if (Session::has('error'))
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                {{ Session::get('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="text-2xl font-bold mb-5 text-center">Form Booking</h2>

        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama -->
            <div>
                <label for="customer_name" class="block text-gray-700">Nama:</label>
                <input type="text" id="customer_name" name="customer_name" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="customer_email" class="block text-gray-700">Email:</label>
                <input type="email" id="customer_email" name="customer_email" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500">
            </div>

            <!-- Pilihan Layanan -->
            <div>
                <label for="service_id" class="block text-gray-700">Pilih Layanan:</label>
                <select id="service_id" name="service_id" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }} - Rp {{ $service->price }}</option>
                    @endforeach

                </select>
            </div>

            <!-- Pilih Tanggal -->
            <div>
                <label for="tanggal_booking" class="block text-gray-700">Tanggal Booking:</label>
                <input type="text" id="tanggal_booking" name="tanggal_booking" required style="cursor: not-allowed"
                    class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500"
                    readonly>
            </div>

            <!-- Kalender Interaktif -->
            <div id="calendar" class="mt-4 bg-white shadow-md rounded-lg p-3"></div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">
                    Pesan Sekarang
                </button>
            </div>
            <div class="my-4 text-center text-red-500 italic text-[12px]">
                <p>* jika anda pesan pada hari sabtu dan minggu , maka akan dikenakan biaya tambahan <span
                        class="font-semibold">Rp
                        50000</span></p>
            </div>
        </form>
    </div>


    <script>
        // Kirim data booking dari Laravel ke JavaScript
        let bookedDates = @json($bookings);

        console.log(bookedDates);
    </script>

</body>


</html>
