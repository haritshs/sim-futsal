<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turnamen;
use App\Tim;
use App\PendaftaranTurnamen;
use Illuminate\Support\Facades\Auth;

class PendaftaranTurnamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data['title'] = "Tambah Turnamen";
        //$data['menu'] = 3;
        $id = Auth::user()->id;
        $data['tims'] = Tim::where('user_id', $id)->get();
        return view('app.pendaftaran', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'turnamen_id' => 'required',
            'nama_team' => 'required',
            'user_id' => 'required',
        ]);

        $turni = Turnamen::findOrFail($id);
        $daftar = new PendaftaranTurnamen();
        $daftar->turnamen_id = $turni->id;
        $daftar->nama_team = $request->nama_team;
        $daftar->user_id = Auth::user()->id;

        $daftar->save();
        return redirect('app/turnamen');
    }

    public function pembayaran($id){
        $daftar = PendaftaranTurnamen::findOrFail($id);
        //$daftar =  new PendaftaranTurnamen();
        
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
            $daftar = PendaftaranTurnamen::where('id',$order_id)->first();
            $daftar->status = 'lunas';
            $daftar->save();

        }else {
            /*$id_user = Auth::user()->id;
            $id_tim = Tim::select('id')->where('user_id', $id_user)->get();
            $iddaftarturney = random_int(100000, 999999);
            
            $data = new PendaftaranTurnamen();

            $data->id = $iddaftarturney;
            $data->user_id = $id_user;
            $data->turnamen_id = $id;
            foreach($id_tim as $role)
            {
                //$data->assign($role);
                $data->tim_id = $role['id'];
            }
            $data->save();*/
            $daftar = PendaftaranTurnamen::findOrFail($id);
        }
        //dd($book);
        
        
        if(!empty($daftar)){

            if($daftar->status == 'tunggu'){
                
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $daftar->id,
                        'gross_amount' => $daftar->turnamen->biaya_daftar,
                    ),
                    'customer_details' => array(
                        'first_name' => 'Sdr.',
                        'last_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => $daftar->user->no_telpon,
                    ),
                );
                 
                $data['snapToken'] = \Midtrans\Snap::getSnapToken($params);
                //dd($params);
                
            }else {
                $status = \Midtrans\Transaction::status($daftar->id);
                $status = json_decode(json_encode($status),true);
                $data['vn'] = isset($status['va_numbers']);
                
                if ($data['vn'] == false) {

                    $data['transaction_id'] = $status['transaction_id'];
                    $data['gross_amount'] = $status['gross_amount'];
                    $data['payment_type'] = $status['payment_type'];
                    $data['transaction_status'] = $status['transaction_status'];
                    $transaction_time = $status['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                    
                }
                else {

                    $data['va_numbers'] = $status['va_numbers'][0]['va_number'];
                    $data['gross_amount'] = $status['gross_amount'];
                    $data['payment_type'] = $status['payment_type'];
                    $data['bank'] = $status['va_numbers'][0]['bank'];
                    $data['transaction_status'] = $status['transaction_status'];
                    $transaction_time = $status['transaction_time'];
                    $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                    //return view('app.pembayaran', $data);
                    //dd($data);
                }
               
                //dd($status);
                // $data['va_numbers'] = $status['va_numbers'][0]['va_number'];
                // $data['gross_amount'] = $status['gross_amount'];
                // $data['bank'] = $status['va_numbers'][0]['bank'];
                // $data['payment_type'] = $status['payment_type'];
                // $data['transaction_status'] = $status['transaction_status'];
                // $transaction_time = $status['transaction_time'];
                // $data['deadline'] = date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($transaction_time)));
                //return view('app.pembayaran', $data);
            }
            
            $data['pendaftar'] = PendaftaranTurnamen::find($id);
            //dd($data);
            return view('app.pembayaran_turnamen', $data);
                   
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
}
