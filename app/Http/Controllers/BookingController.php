<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\Lapangan;
use App\BookingDetail;
use App\Voucher;
use App\Sparing;
use Datetime;
use Pusher;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Midtrans\Config;
use App\Http\Controllers\Midtrans\CoreApi;
use App\Http\Controllers\Midtrans\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use RealRashid\SweetAlert\Facades\Alert;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statusArr = [
            'baru',
            'batal',
            'sukses',
            'diverifikasi'
        ];
        $user_id = Auth::id();
        $req = isset($request)?$request:null;

        if($req){
            $lapang_id = $req->query('lapangan');
            $status = $req->query('status');
            if(!in_array($status, $statusArr)) {
                $status = null;
            }else{
                $where[] = ['status','=',$status];
            }
        }
        $where[] = ['user_id', '=', $user_id];
        $data = Booking::where($where)
                ->whereHas('detail', function($q) use ($request, $lapang_id){
                    if(isset($request) && $request->query('lapangan') && is_numeric($request->query('lapangan'))){
                        $q->where('lapangan_id', $lapang_id);
                    }

                })->orderBy('created_at', 'desc')->get();

        $lapang = Lapangan::all();
        return view('app.booking', ['booking' => $data, 'lapangan' => $lapang, 'lapangan_id' => $lapang_id , 'status' => $status]);
        
        //dd($data);
        /*$data = DB::table('detail_bookings')
            ->select('detail_bookings.lapangan_id', 'school_status.school_code')
            ->join('bookings','bookings.id','=','detail_bookings.booking_id')
            ->where('links.id','!=',35)
            ->where('school_status.academic_year','=','2014-15')
            ->get();
        dd($lapangan);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errors = new MessageBag();
       
        $lapangans = Lapangan::findOrFail($request->lapangan_id);
        
        $isError = false;
        try {
            $id_baru = random_int(100000, 999999);
            $booking = new Booking();
            $booking->user_id = Auth::user()->id;
            $booking->id = $id_baru;

            $total_harga =0;
            foreach ($request->jam as $jam) {
                $total_harga += $lapangans->harga_sewa;
            }
            /*if($request->session()->has('session_sparing')){
                $hadiah = $request->session()->get('hadiah');
                $booking->total_harga = $total_harga + $hadiah;
            }else {
                # code...
            }*/

            //dengan hadiah
            //$hadiah = $request->total_hadiah;
            //$booking->total_harga = $total_harga + $hadiah;
            //dengan hadiah
            $booking->total_harga = $total_harga;
            //$metodbayar = $request->metode;
            $bookid = $booking->id;
            $total =$booking->total_harga;
            $nama = Auth::user()->name;
            $email = Auth::user()->email;
            $telpon = Auth::user()->no_telpon;

            $tanggal = new DateTime($booking->created_at);
            $timer = 60;
            $dueTimeBank = $tanggal->modify("+{$timer} minutes");
            $booking->batas_waktu = $dueTimeBank;

            // if ($request->metode == "1") {
            //     //$this->PembayaranController->bankPayment($bookid, $total, $nama, $email, $telpon);
            //     //return $response;
            //     $booking->metode_bayar = "bank_transfer";
            //     $tanggal = new DateTime($booking->created_at);
            //     $bankTimer = 10;
            //     $dueTimeBank = $tanggal->modify("+{$bankTimer} minutes");
            //     $booking->batas_waktu = $dueTimeBank;
            //     //$this->bankPayment($request, $bookid, $total, $nama, $email, $telpon);
            // }
            // elseif($request->metode == "2"){
            //     $booking->metode_bayar = "bank_transfer";
            //     $tanggal = new DateTime($booking->created_at);
            //     $bankTimer = 30;
            //     $dueTimeBank = $tanggal->modify("+{$bankTimer} minutes");
            //     $booking->batas_waktu = $dueTimeBank;
            //     $booking->metode_bayar = "gopay";
            // }
            // elseif($request->metode == "3"){
            //     $booking->metode_bayar = "shopeepay";
            // }else {
            //     alert()->error('Error','Booking Gagal');
            // }

            if($booking->save()){

                foreach ($request->jam as $jam) {
                    $detail = new BookingDetail();
                    $detail->booking_id = $booking->id;
                    $detail->lapangan_id = $request->lapangan_id;
                    $detail->jam_awal = $jam;
                    $detail->jam_akhir = $jam+1;
                    $detail->tanggal_main = $request->tanggal_main;

                    if(!$detail->save()){
                        $errors->add('msg','Gagal booking lapang, terjadi kesalah sitem.');
                        $isError = true;
                    }
                }
                
                //pusher
                //$book_id = $booking->id;
                //return $this->pembayaran($book_id);
                //kirim ke email
                
                $data = array(
                    'nama' => $nama,
                    'total_harga' => $booking->total_harga,
                );

                Mail::send('app.email_template', $data, function($mail) use($email){
                    $mail->to($email, 'no-reply')->subject("Konfirmasi Booking Primavera Futsal");
                    $mail->from('harits.hs@gmail.com', 'Konfirmasi Pembayaran');
                });
            }else{
                $isError = true;
                alert()->error('Error','Booking Gagal');
                //$errors->add('msg','Gagal booking lapang, terjadi kesalah sitem.');
            }
            if($isError){
                return back();
            }else{
                /*$options = array(
                    'cluster' => \Config::get('pusher.pusher_cluster'),
                    'encrypted' => true
                );
                $pusher = new Pusher\Pusher(
                    \Config::get('pusher.pusher_key'),
                    \Config::get('pusher.pusher_secret'),
                    \Config::get('pusher.pusher_app_id'),
                    $options
                );
  
  
                $data['message'] = 'Order baru dari '.Auth::user()->email.' harap cek';
                $pusher->trigger('booking-baru', 'booking-baru-notif', $data);*/
                //return $this->pembayaran($book_id);
                alert()->success('Sukses','Booking Sukses');
                //return redirect('/booking/sukses_booking/'.$booking->id);
                return redirect('/booking/pembayaran/'.$booking->id);
            }
        } catch (\Exception $e) {
            // print_r($e);

            return back()->withErrors($errors);
        }
    }

    public function bankPayment(Request $req, $bookid, $total, $nama, $email, $telpon){
        
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
            // "bank_transfer" => [
            //     "bank" => "bca",
            //     "va_number" => "111111",
            // ],
            "custom_expiry" => [
                "expiry_duration" => 10,
                "unit" => "minute"
            ],
        );

        $charge = CoreApi::charge($transaction);
    }

    public function daftarSparing(Request $request)
    {
        $errors = new MessageBag();
       
        $lapangans = Lapangan::findOrFail($request->lapangan_id);
        
        $isError = false;
        try {
            $booking = new Booking();
            $booking->user_id = Auth::user()->id;

            $total_harga =0;
            foreach ($request->jam2 as $jam) {
                $total_harga += $lapangans->harga_sewa;
            }

            //dengan hadiah
            $hadiah = $request->total_hadiah;
            $booking->total_harga = $total_harga + $hadiah;
            //dengan hadiah
            // $booking->total_harga = $total_harga;
            $tanggal = new DateTime($booking->created_at);
            $timer = 60;
            $dueTimeBank = $tanggal->modify("+{$timer} minutes");
            $booking->batas_waktu = $dueTimeBank;

            if($booking->save()){

                foreach ($request->jam2 as $jam) {
                    $detail = new BookingDetail();
                    $detail->booking_id = $booking->id;
                    $detail->lapangan_id = $request->lapangan_id;
                    $detail->jam_awal = $jam;
                    $detail->jam_akhir = $jam+1;
                    $detail->tanggal_main = $request->tanggal_main;

                    //dengan sparing
                    $sparing = new Sparing();
                    $id_user = Auth::user()->id;
            
                    $sparing->tgl_main = $request->tanggal_main;
                    $sparing->total_hadiah = $request->total_hadiah;
                    $sparing->status = 'tunggu';
                    $sparing->tim_id = $request->tim_id;
                    $sparing->user_id = $id_user;
                    $sparing->booking_id = $booking->id;
                    $sparing->save();
                    //dengan sparing

                    /*if(isset($_GET['data_sparing'])){
                        $detail = new BookingDetail();
                        $detail->booking_id = $booking->id;
                        $detail->lapangan_id = $request->lapangan_id;
                        $detail->jam_awal = $jam;
                        $detail->jam_akhir = $jam+1;
                        $detail->tanggal_main = $request->tanggal_main;

                        $sparing = new Sparing();
                        $id_user = Auth::user()->id;
                
                        $sparing->tgl_main = $request->tanggal_main;
                        $sparing->total_hadiah = $request->total_hadiah;
                        $sparing->status = 'tunggu';
                        $sparing->tim_id = $request->tim_id;
                        $sparing->user_id = $id_user;
                        $sparing->booking_id = $booking->id;
                        $sparing->save();

                        if(!$detail->save()){
                            $errors->add('msg','Gagal booking lapang, terjadi kesalah sitem.');
                            $isError = true;
                        }
            
                    }else {
                        //$book = Booking::findOrFail($id);
                        $detail = new BookingDetail();
                        $detail->booking_id = $booking->id;
                        $detail->lapangan_id = $request->lapangan_id;
                        $detail->jam_awal = $jam;
                        $detail->jam_akhir = $jam+1;
                        $detail->tanggal_main = $request->tanggal_main;

                        if(!$detail->save()){
                            $errors->add('msg','Gagal booking lapang, terjadi kesalah sitem.');
                            $isError = true;
                        }
                    }*/

                    
                    if(!$detail->save()){
                        $errors->add('msg','Gagal booking lapang, terjadi kesalah sitem.');
                        $isError = true;
                    }
                }
                //kirim ke email
                $user_email = Auth::user()->email;
                $user_name = Auth::user()->name;
                $data = array(
                    'nama' => $user_name,
                    'total_harga' => $booking->total_harga,
                );

                Mail::send('app.email_template', $data, function($mail) use($user_email){
                    $mail->to($user_email, 'no-reply')->subject("Konfirmasi Booking Primavera Futsal");
                    $mail->from('harits.hs@gmail.com', 'Konfirmasi Pembayaran');
                });
            }else{
                $isError = true;
                alert()->error('Error','Booking Gagal');
                $errors->add('msg','Gagal booking lapangan, terjadi kesalah sitem.');
            }
            if($isError){
                return back();
            }else{
                alert()->success('Sukses','Booking Sukses');
                return redirect('/booking/pembayaran/'.$booking->id);
            }
        } catch (\Exception $e) {
            // print_r($e);
            return back()->withErrors($errors);
        }
    }

    public function add_voucher(Request $request, $id)
    {
        //dd($id);
        $booking = Booking::where('id', $id)->first();
        //$bk = Booking::where('id', $id);
        //$hargabooking = 100000;
        $vc = Voucher::where('kode', $request->input_voucher)->first();
        //$vc = Voucher::all();
        //dd($booking);
        
        if(!$vc){
            //$errors->add('msg','Voucher Invalid');
            //return redirect('app.booking');
            //return redirect('booking')->withErrors('Invalid coupon code. Please try again.');
            alert()->success('Error','Invalid coupon code');
            return back();
        }else {
            session()->put('vc', [
                'nama' => $vc->kode,
                'diskon' => $vc->diskon($booking->total_harga),
            ]);
            //$errors->add('msg','Voucher is Valid');
            //return redirect('app.booking');
            $diskon = session()->get('vc')['diskon'] ?? 0;
            //$book = Booking::where('id', $bk->id)->first();
            //dd($bk);
            //$book->total_harga = ;
            //$book->save();
            alert()->success('Success','Voucher is Valid');

            //return redirect('booking')->with('msg','Voucher is Valid');
            //return redirect('booking');
            return back();
        }
        if($request->jam==null || count($request->jam)==0){
            //$errors->add('jam','Jam booking kosong!');
            return back()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function remove_voucher()
    {
        session()->forget('vc');
        alert()->success('Sukses','Voucher Removed');
        //return redirect('booking')->with('msg','Voucher Removed');
        //return redirect('booking');
        return back();
    }

    public function sukses_booking($id)
    {
        $data = Booking::findOrFail($id);
        if($data->user_id != Auth::id()){
            return back();
        }
        return view('app.booking_sukses', ['booking'=>$data]);
    }

    public function sukses_sparing($id)
    {
        $data = Booking::findOrFail($id);
        if($data->user_id != Auth::id()){
            return back();
        }
        return view('app.sparing_sukses', ['booking'=>$data]);
    }

    public function pembayaran($id){
        $book = Booking::findOrFail($id);
        $diskon = session()->get('vc')['diskon'] ?? 0;
         
        $new_total_harga = $book->total_harga-$diskon;
        //dd($new_total_harga);
        \Midtrans\Config::$serverKey = 'SB-Mid-server-htGFPnXMqGIMjOFRjl5hEXlb';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        //dd($book);
        if(isset($_GET['result_data'])){

            $current_status = json_decode($_GET['result_data'],true);
            //dd($current_status);
            
            $order_id = $current_status['order_id'];
            $book = Booking::where('id',$order_id)->first();
            $book->status = 'proses';
            //$book->status = $current_status['transaction_status'];
            $book->total_harga = $new_total_harga;
            $book->save();

        }else {
            $book = Booking::findOrFail($id);
        }
        //dd($book);
        
        
        if(!empty($book)){

            if($book->status == 'baru'){
                // $status = \Midtrans\Transaction::status($book->id);
                // $status = json_decode(json_encode($status),true);
                
                // $params = array(
                //     'transaction_details' => array(
                //         'order_id' => $status['order_id'],
                //         'gross_amount' => $status['gross_amount'],
                //     ),
                //     'customer_details' => array(
                //         'first_name' => 'Sdr.',
                //         'last_name' => $book->user->name,
                //         'email' => $book->user->email,
                //         'phone' => $book->user->no_telpon,
                //     ),
                // );
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $book->id,
                        'gross_amount' => $new_total_harga,
                    ),
                    'customer_details' => array(
                        'first_name' => 'Sdr.',
                        'last_name' => $book->user->name,
                        'email' => $book->user->email,
                        'phone' => $book->user->no_telpon,
                    ),
                );
                 
                $data['snapToken'] = \Midtrans\Snap::getSnapToken($params);
                
                //dd($data);
                
                // $data['tipe'] = $status['payment_type'];
                // $data['vn'] = isset($status['va_numbers']);
                // //dd($data);
                // if ($data['vn'] == false) {
                //     //bank

                //     $data['transaction_id'] = $status['transaction_id'];
                //     $data['gross_amount'] = $status['gross_amount'];
                //     $data['payment_type'] = $status['payment_type'];
                //     $data['transaction_status'] = $status['transaction_status'];
                //     $transaction_time = $status['transaction_time'];
                //     $data['deadline'] = date('Y-m-d H:i:s', strtotime('+10 minute', strtotime($transaction_time)));
                //     //dd($data);
                // }
                // else {
                //     //ewallet

                //     $data['va_numbers'] = $status['va_numbers'][0]['va_number'];
                //     $data['gross_amount'] = $status['gross_amount'];
                //     $data['payment_type'] = $status['payment_type'];
                //     $data['bank'] = $status['va_numbers'][0]['bank'];
                //     $data['transaction_status'] = $status['transaction_status'];
                //     $transaction_time = $status['transaction_time'];
                //     $data['deadline'] = date('Y-m-d H:i:s', strtotime('+10 minute', strtotime($transaction_time)));
                //     //return view('app.pembayaran', $data);
                //     //dd($data);
                // }
                
            }else {
                $status = \Midtrans\Transaction::status($book->id);
                $status = json_decode(json_encode($status),true);
                $data['tipe'] = $status['payment_type'];
                $data['vn'] = isset($status['va_numbers']);
                //dd($data);
                if ($data['vn'] == false) {

                    $data['transaction_id'] = $status['transaction_id'];
                    $data['gross_amount'] = $status['gross_amount'];
                    $data['payment_type'] = $status['payment_type'];
                    $data['transaction_status'] = $status['transaction_status'];
                    $transaction_time = $status['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));
                    //dd($data);
                }
                else {

                    $data['va_numbers'] = $status['va_numbers'][0]['va_number'];
                    $data['gross_amount'] = $status['gross_amount'];
                    $data['payment_type'] = $status['payment_type'];
                    $data['bank'] = $status['va_numbers'][0]['bank'];
                    $data['transaction_status'] = $status['transaction_status'];
                    $transaction_time = $status['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($transaction_time)));
                    //return view('app.pembayaran', $data);
                    //dd($data);
                }
            }
            $data['vouchers'] = Voucher::all();
            $data['booking'] = Booking::find($id);
            //dd($data);
            return view('app.pembayaran', $data);
            
            //return view('app.pembayaran', ['booking' => $data, 'lapangan' => $lapang, 'lapangan_id' => $lapang_id , 'status' => $status]);         
        }
        //dd($book);
    }

    public function update_status(Request $request,$id)
    {
        

        // if(isset($_GET['result_data'])){
        // $current_status = json_decode($_GET['result_data'],true);
        //$idbooking = $request['id_booking'];
        $notif = json_decode($request->getContent(), true);
        $bookid = $notif['order_id'];
        $status_code = $notif['status_code'];
        $book = Booking::where('id', $bookid)->first();

        if(!$book)
        {
            return ['code' => 0, 'message' => "Booking Id Tidak Ditemukan"];
        }
        else
        {
            switch($status_code){
                case '200' :
                    $book->status = 'lunas';
                    break;
                case '201' :
                    $book->status = 'proses';
                    
                    break;
                case '202' :
                    $book->status = 'batal';
                    break;
            }
            $book->save();
            //return Response::json(['token'=>csrf_token()]);
            return ['code' => 1, 'message' => 'success', 'result' => ""];
            //return response('Ok', 200)->header('Content-Type', 'text/plain');
        }
    
        return ['code' => 0, 'message' => 'Error'];
        //return response('Error', 404)->header('Content-Type', 'text/plain');
        
    }

    public function konfirmasi_booking(Request $request,$id){

        
        $foto = "";
        if($request->hasfile('bukti_transfer'))
        {
            $file = $request->file('bukti_transfer');
            $foto = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/', $foto);
            $foto = "/template/images/".$foto;
        }

        $data = Booking::findOrFail($id);
        $data->status = 'lunas';
        $data->nama_pengirim = $request->nama_pengirim;
        $data->bukti_transfer = $foto;

        if($data->save()){

            $request->session()->flash('msg', "Sukses konfirmasi, tunggu sampai admin memverifikasi pembayaran");
        }else{
            $request->session()->flash('msg', "Gagal konfirmasi, Terjadi kesalahan sistem");

        }
        return back();

    }

    public function batal_booking($id)
    {
        //
        $data = Booking::findOrFail($id);
        $tanggal = new DateTime($data->created_at);
        $menit = 60;
        //$eMoneyTimer = 60;
        $now = new Datetime(date("Y-m-d H:i:s"));
        $dueTime = $tanggal->modify("+{$menit} minutes");
        if($dueTime > $now){
            $data->pesan_batal = "Dibatalkan oleh user";
        }else{
            $data->pesan_batal = "Dibatalkan oleh sistem";
        }
        $data->status='batal';

        if(!$data->save()){
            alert()->error('Error','Gagal batal booking');
        }

        return redirect('/booking');
    }

}
