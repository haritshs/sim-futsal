<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data = Booking::orderBy('created_at','desc')->get();
        //return view('booking.index', ['booking'=>$data]);
        $data['title'] = "Data Booking";
        //$data['menu'] = 3;
        $data['bookings'] = Booking::orderBy('created_at','desc')->get();
        $data['no'] = 1;
        return view('booking.index', $data);
    }

    public function getNotif()
    {
        $data['bookings'] = Booking::where('status','lunas')->get();
        //dd($data);
        return view('layouts.navbar', $data);
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

    public function detail_booking($id){

        /*$data = Booking::with('user')->with(['detail'=>function($q){

            $q->with('lapangan');
        }])->orderBy('created_at','desc')->get();

        $arr = [
            'data' => $data
        ];
        dd($arr);
        return view('booking.detail', $arr);*/

        $db = \DB::table('bookings')
            ->join('detail_bookings', 'bookings.id', '=', 'detail_bookings.booking_id')
            ->join('users', 'users.id', '=', 'bookings.user_id ')
            ->join('lapangans', 'lapangans.id', '=', 'detail_bookings.lapangan_id')
            ->where('bookings.id', $id)
            ->get();

        return view('booking.form_detail', ['db' => $db]);
        dd($db);
    }

    public function verifikasi_booking($id)
    {
        $data = Booking::findOrFail($id);
        $data->status='diverifikasi';
        if($data->save()){
            /*$options = array(
              'cluster' => \Config::get('pusher.pusher_cluster'),
              'encrypted' => true
            );
            $pusher = new Pusher\Pusher(
              \Config::get('pusher.pusher_key'),
              \Config::get('pusher.pusher_secret'),
              \Config::get('pusher.pusher_app_id'),
              $options
            );*/


            $pdata['message'] = 'Booking anda pada tanggal '.date('d-m-Y', strtotime($data->created_at)).' sudah diverifikasi';
            $pdata['id'] = $id;
            $pdata['user_id'] = $data->user_id;
            $pdata['status'] = 'diverifikasi';

            //$pusher->trigger('new-order', 'order-status-change', $pdata);
            \Session::flash('msg', 'Sukses memverifikasi booking');
        }else{
            \Session::flash('msg', 'Gagal memverifikasi booking');
        }
        return back();
        //return redirect('booking.index');
    }

    public function batal_booking(Request $req, $id)
    {
        //
        $data = Booking::findOrFail($id);
        $data->status='batal';
        $data->pesan_batal = $req->pesan_batal;
        if($data->save()){
            /*$options = array(
              'cluster' => \Config::get('pusher.pusher_cluster'),
              'encrypted' => true
            );
            $pusher = new Pusher\Pusher(
              \Config::get('pusher.pusher_key'),
              \Config::get('pusher.pusher_secret'),
              \Config::get('pusher.pusher_app_id'),
              $options
            );*/


            $pdata['message'] = 'Booking anda pada tanggal '.date('d-m-Y', strtotime($data->created_at)).' dibatalkan admin karena '.$data->pesan_batal;
            $pdata['id'] = $id;
            $pdata['user_id'] = $data->user_id;
            $pdata['status'] = 'batal';

            //$pusher->trigger('new-order', 'order-status-change', $pdata);

            \Session::flash('msg', 'Sukses membatalkan booking');
        }else{
            \Session::flash('msg', 'Gagal membatalkan booking');
        }

        return back();
    }

    public function laporan(Request $request){

        $data['title'] = "Laporan Transaksi";
        $data['no'] = 1;
        //return view('laporan.index', $data);

        if(!isset($_GET['tipe'])) {
	    	return view('laporan.index', $data);
    	} else {
    		$data['data'] = $request->toArray();
    		switch ($request->tipe) {
    			case 'all':
    				$data['bookings'] = Booking::whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'baru' :
    				$data['bookings'] = Booking::where('bookings.status', 'baru')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'diverifikasi' :
    				$data['bookings'] = Booking::where('bookings.status', 'diverifikasi')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'batal' :
    				$data['bookings'] = Booking::where('bookings.status', 'batal')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'lunas' :
    				$data['bookings'] = Booking::where('bookings.status', 'lunas')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    		}
    		if($request->tipe == 'all'){
    			
    		} else if($request->tipe == 'baru'){

    		}
    		//dd($data);
    		return view('laporan.show', $data);
    	}
    }

    public function cetak_laporan(Request $request){

        $data['title'] = "Cetak Laporan Transaksi";
        $data['no'] = 1;
        //return view('laporan.index', $data);

        if(!isset($_GET['tipe'])) {
	    	return view('laporan.index', $data);
    	} else {
    		$data['data'] = $request->toArray();
    		switch ($request->tipe) {
    			case 'all':
    				$data['bookings'] = Booking::whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'baru' :
    				$data['bookings'] = Booking::where('bookings.status', 'baru')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'diverifikasi' :
    				$data['bookings'] = Booking::where('bookings.status', 'diverifikasi')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'batal' :
    				$data['bookings'] = Booking::where('bookings.status', 'batal')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    			case 'lunas' :
    				$data['bookings'] = Booking::where('bookings.status', 'lunas')->whereBetween('bookings.created_at', [$request['start_date'], $request['end_date']])
    				->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
    				->join('users', 'users.id', '=', 'bookings.user_id')
    				->get();
    				break;
    		}
    		if($request->tipe == 'all'){
    			
    		} else if($request->tipe == 'baru'){

    		}
    		//dd($data);
    		return view('laporan.show', $data);
    	}
    }

    public function showLaporan(Request $request){
        if($request->query('from')!=null && $request->query('to')!=null && $request->query('status')!=null){
            $from = $request->query('from');
            $to = $request->query('to');
            $dateFrom = date($from);
            $dateTo = date($to);
            $status = $request->query('status');
            if($dateFrom>$dateTo){
                $request->session()->flash('err', "Tanggal awal tidak boleh lebih besar dari tanggal akhir");
                return back();
            }else{
                $data = Booking::whereBetween('created_at', [$from,$to])->where('status' , $status)->get();

                return view('laporan.show',['booking'=>$data, 'from'=>$from, 'to'=>$to , 'status'=>$status]);
            }


        }else{
            $request->session()->flash('err', "Harap lengkapi form");
            return back();
        }
    }
}
