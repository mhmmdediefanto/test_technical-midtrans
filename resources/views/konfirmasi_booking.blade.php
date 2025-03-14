<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Konfirmasi Booking {{ $booking->customer_name }}</title>
</head>

<bod class="bg-gradient-to-tr from-white to-cyan-300 flex justify-center items-center  shadow-sm rounded-lg h-screen">
    <div class=" bg-white shadow-sm rounded-lg p-5">
        <div class="flex flex-col justify-center">
            <h2 class="font-bold text-center text-slate-800 my-3">Pembayaran Berhasil!</h2>
            <p class="text-[12px] text-slate-600 ">Terima kasih, pesanan Anda dengan ID
                <strong>{{ $booking->id }}</strong> telah berhasil dibayar.
            </p>
            <p class="text-[15px] text-slate-600 font-bold text-center my-2">Detail Pesanan:</p>
            <div>
                <p class="text-[12px] text-slate-600 ">Nama Pelanggan: <strong>{{ $booking->customer_name }}</strong>
                </p>
                <p class="text-[12px] text-slate-600 ">Tanggal Booking: <strong>{{ $booking->tanggal_booking }}</strong>
                </p>
                <p class="text-[12px] text-slate-600 ">Jumlah Sesi: <strong>{{ $booking->total_sessions }}</strong></p>
                <p class="text-[12px] text-slate-600 ">Total Harga: <strong>Rp
                        {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>
            </div>
        </div>
    </div>
    </body>

</html>
