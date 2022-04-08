<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use Datetime;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Booking::with('user')->with(['detail'=>function($p){
            $p->with('lapangan');
        }])->orderBy('created_at','desc')->get();

        $arr = [
            'data' => $data
        ];
        //dd($arr);
        return $arr;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    public function getByUser($id){

        $data = Booking::with('user')->with(['detail'=>function($q){

            $q->with('lapangan');
        }])->where('user_id', $id)->orderBy('created_at','desc')->get();

        // $arr = [
        //     'data' => $data
        // ];

        if($data->count()!=0 && $id == $data->first()->user_id){
            return $data;
        }else{
            return null;
        }
    }

    
    public function verifikasi(){
        $data = Booking::where('status','baru')->get();
        foreach ($data as $book) {
            $tanggal = new DateTime($book->created_at);
            $metodeBayar = $book->metode_bayar;
            
            $menit = 60;
            // $bankTimer = 10;
            // $eMoneyTimer = 30;
            $now = new Datetime(date("Y-m-d H:i:s"));
            $dueTime = $tanggal->modify("+{$menit} minutes");
            //dd($tanggal);
            // $dueTimeBank = $tanggal->modify("+{$bankTimer} minutes");
            // $dueTimeEMoney = $tanggal->modify("+{$eMoneyTimer} minutes");

            if($now > $dueTime){
                $book->status = 'batal';
                $book->pesan_batal = 'Batas waktu pembayaran selesai, Dibatalkan Oleh Sistem';
                $book->save();
            }
            

            // if($metodeBayar == 'bank_transfer' && $now > $dueTimeBank){
            //     $book->status = 'batal';
            //     $book->pesan_batal = 'Batas waktu pembayaran selesai, Dibatalkan Oleh Sistem';
            //     $book->save();
            
            // }elseif($metodeBayar == 'gopay' && $now > $dueTimeEMoney){
            //     $book->status = 'batal';
            //     $book->pesan_batal = 'Batas waktu pembayaran selesai, Dibatalkan Oleh Sistem';
            //     $book->save();
            // }
            // elseif($metodeBayar == 'shopeepay' && $now > $dueTimeEMoney){
            //     $book->status = 'batal';
            //     $book->pesan_batal = 'Batas waktu pembayaran selesai, Dibatalkan Oleh Sistem';
            //     $book->save();
            // }
        }
        return "ok";
    }
}
