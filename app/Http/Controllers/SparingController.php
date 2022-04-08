<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sparing;
use App\LawanSparing;
use App\Tim;
use App\User;
use App\Booking;
use App\PemenangSparing;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon;

class SparingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['sparings'] = Sparing::all();
        //$data['lawans'] = LawanSparing::all();
        /*$data['bookings'] = DB::table('sparings')
            ->select('*')
            ->join('lawan_sparings', 'lawan_sparings.sparing_id', '=', 'sparings.id')
            ->join('bookings', 'sparings.booking_id', '=', 'bookings.id')
            ->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
            ->join('lapangans', 'lapangans.id', '=', 'detail_bookings.lapangan_id')
            ->join('tims', 'tims.id', '=', 'sparings.tim_id')
            ->get();*/
        
        $data['sparings'] = Sparing::with('lawan')->with('booking')->get();
        //$data['sparings'] = LawanSparing::with('sparing')->get();
        $data['no'] = 1;
        $data['title'] = 'Data Sparing';
        //$data['sparings'] = Sparing::with('lawan')->with('booking')->whereDate('tgl_main', '>', Carbon::now())->get();
        //$data['sparings'] = Sparing::with('lawan')->with('booking')->get();
        
        //dd($data);
        return view('sparing.index', $data);
    }

    public function tampil_sparing()
    {
        //$data['sparings'] = Sparing::all();
        //$data['lawans'] = LawanSparing::all();
        $data['bookings'] = DB::table('sparings')
            ->select('*')
            ->join('lawan_sparings', 'lawan_sparings.sparing_id', '=', 'sparings.id')
            ->join('bookings', 'sparings.booking_id', '=', 'bookings.id')
            ->join('detail_bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
            ->join('lapangans', 'lapangans.id', '=', 'detail_bookings.lapangan_id')
            ->join('tims', 'tims.id', '=', 'sparings.tim_id')
            ->get();
        
        //$data['sparings'] = Sparing::with('lawan')->get();
        $date = Carbon::now();
        $date->subDays(2);
        $data['sparings'] = Sparing::with('lawan')->with('booking')->whereDate('tgl_main', '>', $date)->get();
        //$data['sparings'] = Sparing::with('lawan')->with('booking')->get();
         
        //dd($data);
        return view('app.sparing', $data);
    }

    public function tampil_pemenang($id)
    {
        /*$data['menangs'] = DB::table('pemenang_sparings')
            ->select('*')
            ->join('sparings', 'sparings.id', '=', 'pemenang_sparings.sparing_id')
            ->join('tims', 'tims.id', '=', 'pemenang_sparings.tim_id')
            ->where('pemenang_sparings.sparing_id', $id)
            ->get();*/
        $data['menangs'] = PemenangSparing::with('sparing')->where('sparing_id', $id)->get();

        //dd($data);
        return view('app.pemenang_sparing', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $data['tims'] = Tim::where('user_id', $id)->get();
        //dd($data);
        return view('app.daftar_sparing', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$this->validate($request, [
            'tgl_main' => 'required',
            'total_hadiah' => 'required',
            'status' => 'required',
            'user_id' => 'required',
            'tim_id' => 'required',
        ]);*/

        $data = new Sparing();

        $id_user = Auth::user()->id;

        /*$data->tgl_main = $request->get('tgl_main');
        $data->total_hadiah = $request->get('total_hadiah');
        $data->status = 'tunggu';
        $data->tim_id = $request->get('tim_id');
        $data->user_id = $id_user;*/

        /*session()->put('session_sparing', [
            'tgl' => $request->get('tgl_main'),
            'hadiah' => $request->get('total_hadiah'),
            'idtim' => $request->get('tim_id'),
            'iduser' => $id_user,
        ]);*/

        if($request->session()->has('session_sparing')){
			$request->session()->flash('msg', "Sukses Daftar Sparing");
		}else{
			$request->session()->flash('err', "Gagal Daftar Sparing");
		}
        return redirect()->route('/sparing');

        /*$data->save();

        $request->session()->flash('msg', 'Sukses Daftar Sparing');
        return redirect('/sparing/create');*/
        /*if($data->save()){
            $request->session()->flash('msg', "Sukses Daftar Sparing");
        }else{
            $request->session()->flash('err', "Gagal Daftar Sparing");

        }*/
        return redirect()->route('/sparing/create');
    }

    public function daftar_sparing(Request $request)
    {
        /*$this->validate($request, [
            'tgl_main' => 'required',
            'total_hadiah' => 'required',
            'status' => 'required',
            'user_id' => 'required',
            'tim_id' => 'required',
        ]);*/
        //$idsparing = random_int(100000, 999999);
        $data = new Sparing();

        //$data->id = $idsparing;
        $data->tgl_main = $request->get('tgl_main');
        $data->total_hadiah = $request->get('total_hadiah');
        $data->status = 'tunggu';
        $data->tim_id = $request->get('tim_id');
        $data->user_id = Auth::user()->id;

        //$data->save();

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        //return redirect('tim');
        if($data->save()){
            $request->session()->flash('msg', "Sukses Daftar Sparing");
        }else{
            $request->session()->flash('err', "Gagal Daftar Sparing");

        }
        return redirect()->route('/sparing/create');
    }

    public function lawan_sparing(Request $request, $id)
    {
        /*$this->validate($request, [
            'user_id' => 'required',
            'sparing_id' => 'required',
            'tim_id' => 'required',
        ]);*/

        $id_user = Auth::user()->id;
        $id_tim = Tim::select('id')->where('user_id', $id_user)->get();
        $idlawan = random_int(100000, 999999);
        $hadiah = DB::table('sparings')
                ->select('total_hadiah')
                ->join('lawan_sparings', 'sparings.id', '=', 'lawan_sparings.sparing_id')
                ->where('sparings.id', $id)
                ->get();
        //$tim = implode("," , $id_tim);
        //$id_tim->implode('id', ', ');
        


        $data = new LawanSparing();

        $data->id = $idlawan;
        $data->user_id = $id_user;
        $data->sparing_id = $id;
        foreach($id_tim as $role)
        {
            $data->tim_id = $role['id'];
        }
        $sp = Sparing::where('id', $id)->first();
        $sp->status = 'terima';
        $sp->save();

        if($data->save()){
            alert()->success('Sukses','Sukses Daftar Sparing');
        }else{
            alert()->error('Error','Gagal Daftar Sparing');
        }
        
        return redirect()->back();
    }

    public function pembayaran($id){
        $sparing = Sparing::findOrFail($id);
        
        //dd($sparing);
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
            $sparing = Sparing::where('id',$order_id)->first();
            $sparing->status = 'terima';
            $sparing->save();

            $id_user = Auth::user()->id;
            $id_tim = Tim::select('id')->where('user_id', $id_user)->get();
            $idlawan = random_int(100000, 999999);
            $data = new LawanSparing();

            $data->id = $idlawan;
            $data->user_id = $id_user;
            $data->sparing_id = $id;
            foreach($id_tim as $role)
            {
                //$data->assign($role);
                $data->tim_id = $role['id'];
            }
            $data->save();

        }else {
            $sparing = Sparing::findOrFail($id);
        }
        //dd($book);
        
        
        if(!empty($sparing)){

            if($sparing->status == 'tunggu'){
                
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $sparing->id,
                        'gross_amount' => $sparing->total_hadiah,
                    ),
                    'customer_details' => array(
                        'first_name' => 'Sdr.',
                        'last_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => $sparing->user->no_telpon,
                    ),
                );
                 
                $data['snapToken'] = \Midtrans\Snap::getSnapToken($params);
                //dd($data);
                
            }else {
                $status = \Midtrans\Transaction::status($sparing->id);
                $status = json_decode(json_encode($status),true);
                //dd($status);
                $data['va_numbers'] = $status['va_numbers'][0]['va_number'];
                //$data['va_numbers'] = $status['permata_va_number'];
                $data['gross_amount'] = $status['gross_amount'];
                $data['payment_type'] = $status['payment_type'];
                $data['bank'] = $status['va_numbers'][0]['bank'];
                $data['transaction_status'] = $status['transaction_status'];
                $transaction_time = $status['transaction_time'];
                $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                //return view('app.pembayaran', $data);
            }
            
            $data['sparings'] = Sparing::find($id);
            return view('app.pembayaran_sparing', $data);
                   
        }
        //dd($book);
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
        $data['title'] = "Pilih Pemenang";
        $data['sparings'] = Sparing::find($id);
        $data['lawans'] = LawanSparing::where('sparing_id', $id)->get();
        // $data['sparings'] = DB::table('sparings')
        //     ->select('*', 'sparings.tim_id', 'lawan_sparings.tim_id as tim_lawan')
        //     ->join('lawan_sparings', 'lawan_sparings.sparing_id', '=', 'sparings.id')
        //     ->join('tims', 'tims.id', '=', 'lawan_sparings.tim_id')
        //     ->where('sparings.id' , $id)
        //     ->get();
        //dd($data);
        return view('sparing.pemenang', $data);
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
        $this->validate($request, [
            'tim_id' => 'required',
            'pesan' => 'required',
            'hadiah_pemenang' => 'required',
            'bukti_transfer' => 'required',
            'nama_pengirim' => 'required',
        ]);

        //$turni = Sparing::findOrFail($id);
        $pemenang = new PemenangSparing();
        $pemenang->tim_id = $request->tim_id;
        $pemenang->pesan = $request->pesan;
        $pemenang->hadiah_pemenang = $request->hadiah_pemenang;
        $pemenang->bukti_transfer = $request->bukti_transfer;
        $pemenang->nama_pengirim = $request->nama_pengirim;

        
        if ($pemenang->save()) {
            alert()->success('Sukses','Sukses Update Data');
        }else{
            alert()->error('Error','Gagal Update Data');
        }
        return redirect('sparing.index');
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
}
