<?php

namespace App\Http\Controllers;

use App\Models\Boking;
use App\Models\Payment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;

class BokingController extends Controller
{



    public function index()
    {
        $services = Service::select('id', 'name', 'price')->get();
        // Ambil semua booking yang sudah dibuat
        $bookings = Boking::with('service', 'payment')->where('status_booking', 'confirmed')->select('tanggal_booking', 'service_id')->get();
        if (!$bookings) {
            return null;
        }
        return view('index', compact('bookings', 'services'));
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // dd($request->all());
            $request->validate([
                'customer_name' => 'required',
                'customer_email' => 'required',
                'service_id' => 'required',
                'tanggal_booking' => 'required'
            ]);

            // dd($validatedData);
            $bookings = Boking::where('tanggal_booking', $request->tanggal_booking)
                ->where('service_id', $request->service_id)
                ->exists();
            // Jika sudah dibooking, kembalikan dengan pesan error
            if ($bookings) {
                // dd('errors bookingss');
                $serviceName = $request->service_id == 1 ? 'PS4' : 'PS5'; // Menentukan nama layanan
                return  back()->with('error', "Tanggal yang anda pilih untuk layanan $serviceName sudah dibooking.");
            }

            $service = Service::findOrFail($request->service_id);
            $price = $service->price;

            $dayOfWeek  = Carbon::parse($request->tanggal_booking)->dayOfWeek;

            $surcharge = ($dayOfWeek == 6 || $dayOfWeek == 0) ? 50000 : 0;
            $totalPrice = $price + $surcharge;



            $bookings = Boking::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'service_id' => $request->service_id,
                'tanggal_booking' => $request->tanggal_booking,
                'price' => $price,
                'surcharge' => $surcharge,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);
            if ($bookings) {

                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');


                $uuid = bin2hex(random_bytes(16));
                // dd($uuid);
                // Buat parameter pembayaran
                $params = [
                    'transaction_details' => [
                        'order_id' => 'BOOK-' . $uuid,
                        'gross_amount' => $totalPrice,
                    ],
                    'item_details' => [
                        [
                            'id' => 'BOOK-' . $uuid,
                            'name' => $service->name,
                            'price' => $totalPrice,
                            'quantity' => 1,
                        ]
                    ],
                    'customer_details' => [
                        'first_name' => $bookings->customer_name,
                        'email' => $bookings->customer_email,
                    ]
                ];


                // Buat Snap Token dari Midtrans
                $snapToken = Snap::getSnapToken($params);

                // dd($snapToken);

                // Simpan transaksi dengan status "pending"
                Payment::create([
                    'order_id' => 'BOOK-' . $uuid,
                    'boking_id' => $bookings->id,
                    'transaction_id' => 'BOOK-' . $uuid,
                    'amount' => $totalPrice,
                    'status' => 'pending',
                    'snap_token' => $snapToken
                ]);
                DB::commit();
                // Redirect ke halaman pembayaran dengan token Midtrans
                return view('payment', compact('snapToken', 'bookings'));
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $th->getMessage());
        }
    }

    public function konfirmasi_booking($id)
    {
        $booking = Boking::findOrFail($id);
        $booking->status_booking = 'confirmed';
        $booking->save();
        return view('konfirmasi_booking', compact('booking'));
    }

    public function history()
    {

        $bookings = Boking::with('service')->latest()->get();
        return view('history_booking', compact('bookings'));
    }
}
