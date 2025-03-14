<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>payment app booking</title>
</head>

<body>
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6 mt-10 text-center">
        <h2 class="text-2xl font-bold mb-5">Pembayaran Booking</h2>
        <p class="text-gray-600 mb-4">Total Pembayaran: <strong>Rp
                {{ number_format($bookings->total_price, 0, ',', '.') }}</strong></p>

        <button id="pay-button"
            class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-6 rounded-lg transition duration-300">
            Bayar Sekarang
        </button>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            // SnapToken acquired from previous step
            snap.pay('<?= $snapToken ?>', {
                // Optional
                onSuccess: function(result) {

                    window.location.href = "{{ route('konfirmasi_booking', ['id' => $bookings->id]) }}"
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        };
    </script>
</body>

</html>
