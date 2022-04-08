<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Transaction;
use App\Booking;
use App\Sparing;

class PembayaranController extends Controller
{
    //public $snapToken;
    public function render($id){
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-htGFPnXMqGIMjOFRjl5hEXlb';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );
 
        $data['snapToken'] = \Midtrans\Snap::getSnapToken($params);
        //dd($snapToken);
        return view('app.pembayaran', $data);
    }

    public function bankPayment(Request $req, $bookid, $total, $nama, $email, $telpon){
        try {
            $transaction = array(
                "payment_type" => "bank_transfer",
                "transaction_details" => [
                    "order_id" => $bookid,
                    "gross_amount" => $total,
                ],
                "customer_details" => [
                    "first_name" => "Sdr.",
                    "last_name" => $nama,
                    "email" => $email,
                    "phone" => $telpon,
                ],
                "bank_transfer" => [
                    "bank" => "bca",
                    "va_number" => "111111",
                ]
            );

            $charge = CoreApi::charge($transaction);
            if (!$charge) {
                return ['code' => 0, 'message' => 'error'];
            }
            return ['code' => 1, 'message' => 'success', 'result' => $charge];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0, 'message' => 'error'];
        }
        
    }

    public function gopayPayment(Request $req){
        try {
            $transaction = array(
                "payment_type" => "gopay",
                "transaction_details" => [
                    "order_id" => date('Y-m-dHis'),
                    "gross_amount" => 50000
                ],
                "customer_details" => [
                    "first_name" => "Bejo",
                    "last_name" => "Utomo",
                    "email" => "bejo@midtrans.com",
                    "phone" => "+628123456",
                ],
                "gopay" => [
                    "enable_callback" => true,
                    "callback_url" => "someapps://callback",
                ]
            );

            $charge = CoreApi::charge($transaction);
            if (!$charge) {
                return ['code' => 0, 'message' => 'error'];
            }
            return ['code' => 1, 'message' => 'success', 'result' => $charge];
        } catch (\Exception $e) {
            dd($e);
            return ['code' => 0, 'message' => 'error'];
        }
        
    }

    public function update_status(Request $request, $id)
    {
        
        try {
            
            $idbooking = $id;
            $status = Transaction::status($idbooking);
            
            
            $notif = json_decode(json_encode($status),true);
            
            $status_code = $notif['status_code'];
            $booking = Booking::where('id', $idbooking)->first();

            if(!$booking)
            {
                return ['code' => 0, 'message' => "Booking Id Tidak Ditemukan"];
            }
            else
            {
                switch($status_code){
                    case '200' :
                        $booking->status = 'lunas';
                        break;
                    case '201' :
                        $booking->status = 'proses';
                        break;
                    case '202' :
                        $booking->status = 'batal';
                        break;
                    case '407' :
                        $booking->status = 'batal';
                        break;
                }
                
                $booking->save();
                
                $data['booking'] = $booking;
                $data['vn'] = isset($notif['va_numbers']);
                
                if ($data['vn'] == false) {

                    $data['transaction_id'] = $notif['transaction_id'];
                    $data['gross_amount'] = $notif['gross_amount'];
                    $data['payment_type'] = $notif['payment_type'];
                    $data['transaction_status'] = $notif['transaction_status'];
                    $transaction_time = $notif['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));
                    
                }
                else {

                    $data['va_numbers'] = $notif['va_numbers'][0]['va_number'];
                    $data['gross_amount'] = $notif['gross_amount'];
                    $data['payment_type'] = $notif['payment_type'];
                    $data['bank'] = $notif['va_numbers'][0]['bank'];
                    $data['transaction_status'] = $notif['transaction_status'];
                    $transaction_time = $notif['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));
                    //return view('app.pembayaran', $data);
                    //dd($data);
                }
                return view('app.pembayaran', $data);
            }
        } catch (\Exception $e) {
            $data['booking'] = Booking::where('id', $id)->first();
            return view('app.pembayaran', $data);
        }
    }

    public function update_status_sparing(Request $request, $id)
    {
        
        try {
            
            
            $status = Transaction::status($id);
            
            
            $notif = json_decode(json_encode($status),true);
            
            $status_code = $notif['status_code'];
            $sparing = Sparing::where('id', $id)->first();

            if(!$sparing)
            {
                return ['code' => 0, 'message' => "Sparing Id Tidak Ditemukan"];
            }
            else
            {
                switch($status_code){
                    case '200' :
                        $sparing->status = 'lunas';
                        break;
                    case '201' :
                        $sparing->status = 'proses';
                        break;
                    case '202' :
                        $sparing->status = 'batal';
                        break;
                    case '407' :
                        $sparing->status = 'batal';
                        break;
                }
                
                $sparing->save();
                
                $data['sparings'] = $sparing;
                $data['vn'] = isset($notif['va_numbers']);
                
                if ($data['vn'] == false) {

                    $data['transaction_id'] = $notif['transaction_id'];
                    $data['gross_amount'] = $notif['gross_amount'];
                    $data['payment_type'] = $notif['payment_type'];
                    $data['transaction_status'] = $notif['transaction_status'];
                    $transaction_time = $notif['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                    
                }
                else {

                    $data['va_numbers'] = $notif['va_numbers'][0]['va_number'];
                    $data['gross_amount'] = $notif['gross_amount'];
                    $data['payment_type'] = $notif['payment_type'];
                    $data['bank'] = $notif['va_numbers'][0]['bank'];
                    $data['transaction_status'] = $notif['transaction_status'];
                    $transaction_time = $notif['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                    //return view('app.pembayaran', $data);
                    //dd($data);
                }
                return view('app.pembayaran_sparing', $data);
            }
        } catch (\Exception $e) {
            $data['sparings'] = Sparing::where('id', $id)->first();
            return view('app.pembayaran_sparing', $data);
        }
    }

    public function update_status_turnamen(Request $request, $id)
    {
        
        try {
            
            
            $status = Transaction::status($id);
            
            
            $notif = json_decode(json_encode($status),true);
            
            $status_code = $notif['status_code'];
            $sparing = Sparing::where('id', $id)->first();

            if(!$sparing)
            {
                return ['code' => 0, 'message' => "Sparing Id Tidak Ditemukan"];
            }
            else
            {
                switch($status_code){
                    case '200' :
                        $sparing->status = 'lunas';
                        break;
                    case '201' :
                        $sparing->status = 'proses';
                        break;
                    case '202' :
                        $sparing->status = 'batal';
                        break;
                    case '407' :
                        $sparing->status = 'batal';
                        break;
                }
                
                $sparing->save();
                
                $data['sparings'] = $sparing;
                $data['vn'] = isset($notif['va_numbers']);
                
                if ($data['vn'] == false) {

                    $data['transaction_id'] = $notif['transaction_id'];
                    $data['gross_amount'] = $notif['gross_amount'];
                    $data['payment_type'] = $notif['payment_type'];
                    $data['transaction_status'] = $notif['transaction_status'];
                    $transaction_time = $notif['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                    
                }
                else {

                    $data['va_numbers'] = $notif['va_numbers'][0]['va_number'];
                    $data['gross_amount'] = $notif['gross_amount'];
                    $data['payment_type'] = $notif['payment_type'];
                    $data['bank'] = $notif['va_numbers'][0]['bank'];
                    $data['transaction_status'] = $notif['transaction_status'];
                    $transaction_time = $notif['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                    //return view('app.pembayaran', $data);
                    //dd($data);
                }
                return view('app.pembayaran_sparing', $data);
            }
        } catch (\Exception $e) {
            $data['sparings'] = Sparing::where('id', $id)->first();
            return view('app.pembayaran_sparing', $data);
        }
    }
}
