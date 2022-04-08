<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Karyawan;
use App\Kehadiran;
use App\Shift;
use DateTime;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class KehadiranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulan_ini = Carbon::now()->format('F');
        $data['title'] = "Data Kehadiran Karyawan bulan $bulan_ini";
        //$data['menu'] = 3;
        //$data['karyawans'] = Karyawan::all();
        $idkaryawan = Auth::guard('admin')->user()->karyawan_id;
        $data['karyawans'] = Karyawan::where('id', '=', $idkaryawan)->get();
        //$data['kehadirans'] = Kehadiran::all();
        
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        
        //dd($idkaryawan);
        $data['kehadirans'] = DB::table('kehadirans')
                ->selectRaw(" *,".
                "SUM(CASE WHEN kehadirans.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS h, ".
                "SUM(CASE WHEN kehadirans.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS a, ".
                "SUM(CASE WHEN kehadirans.keterangan = 'Izin' THEN 1 ELSE 0 END) AS i, ".
                "SUM(CASE WHEN kehadirans.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS s, ".
                "SUM(CASE WHEN kehadirans.keterangan = 'Cuti' THEN 1 ELSE 0 END) AS c")
                ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
                ->whereRaw('month(kehadirans.tanggal) = '.$bulan.'')
                ->whereRaw('year(kehadirans.tanggal) = '.$tahun.'')
                ->where('kehadirans.karyawan_id', '=', $idkaryawan)
                ->get();
        $data['no'] = 1;
        //$createdAt = Carbon::parse($data['kehadirans']['kehadirans.tanggal']);
        //dd($data);
        return view('kehadiran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Kehadiran Karyawan";
        //$data['mobils'] = Mobil::where('status_sewa', "1")->get();
        //$data['menu'] = 3;
        $data['karyawans'] = Karyawan::all();
        $data['kehadirans'] = Kehadiran::all();
        $data['no'] = 1;

        $date = date('Y-m-d');
        $cek_absen  = Kehadiran::where(['tanggal' => $date, 'karyawan_id' => $id])->get()->first();
        //dd($cek_absen);
        if(is_null($cek_absen)) {
            $data['info'] = array(
                
                "btnIn"     => "",
                "btnOut"    => "disabled");
        } elseif($cek_absen->jam_keluar == NULL) {
            $data['info'] = array(
                
                "btnIn"     => "disabled",
                "btnOut"    => "");
        } else {
            $data['info'] = array(
                
                "btnIn"     => "disabled",
                "btnOut"    => "disabled");
        }

        // $data_absen = Absen::where('user_id', $user_id)
        //             ->orderBy('date', 'desc')
        //             ->paginate(20);
        //return view('kehadiran.create', compact('data_absen', 'info'));
        return view('kehadiran.create', $data);
    }

    public function absen($id)
    {
        $data['title'] = "Tambah Kehadiran Karyawan";
        //$data['mobils'] = Mobil::where('status_sewa', "1")->get();
        //$data['menu'] = 3;
        $data['karyawans'] = Karyawan::where(['id' => $id])->get();
        //$data['kehadirans'] = Kehadiran::where(['karyawan_id' => $id])->get();
        
        $date = date('Y-m-d');
        $cek_absen  = Kehadiran::where(['tanggal' => $date, 'karyawan_id' => $id])->get()->first();
        //dd($cek_absen);

        if(is_null($cek_absen)) {
            $data['info'] = array(
                
                "btnIn"     => "",
                "btnOut"    => "disabled");
        } elseif($cek_absen->jam_keluar == NULL) {
            $data['info'] = array(
                
                "btnIn"     => "disabled",
                "btnOut"    => "");
        } else {
            $data['info'] = array(
                
                "btnIn"     => "disabled",
                "btnOut"    => "disabled");
        }
        //dd($data);
        // $data_absen = Absen::where('user_id', $user_id)
        //             ->orderBy('date', 'desc')
        //             ->paginate(20);
        //return view('kehadiran.create', compact('data_absen', 'info'));
        return view('kehadiran.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$kehadiran = Kehadiran::whereUserId($request->user_id)->whereTanggal(date('Y-m-d'))->first();
        if ($kehadiran) {
            return redirect()->back()->with('error','Absensi hari ini telah terisi');
        }
        $data = $request->validate([
            'keterangan'    => ['required'],
            'user_id'    => ['required']
        ]);
        $data['tanggal'] = date('Y-m-d');
        if ($request->keterangan == 'Masuk' || $request->keterangan == 'Telat') {
            $data['jam_masuk'] = $request->jam_masuk;
            if (strtotime($data['jam_masuk']) >= strtotime('07:00:00') && strtotime($data['jam_masuk']) <= strtotime('08:00:00')) {
                $data['keterangan'] = 'Masuk';
            } else if (strtotime($data['jam_masuk']) > strtotime('08:00:00') && strtotime($data['jam_masuk']) <= strtotime('17:00:00')) {
                $data['keterangan'] = 'Telat';
            } else {
                $data['keterangan'] = 'Alpha';
            }
        }
        Kehadiran::create($data);
        return redirect()->back()->with('success','Kehadiran berhasil ditambahkan');*/
        
        /*$this->validate($request, [
            'keterangan' => 'required',
            'tanggal' => 'required',
            'karyawan_id' => 'required',
        ]);

        $data = new Kehadiran();

        $data->keterangan = $request->get('keterangan');
        $data->tanggal = $request->get('tanggal');
        $data->karyawan_id = $request->get('karyawan_id');

        $data->save();

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        return view('kehadiran.index');*/

        $jam_shift = $request->shift_masuk;
        $karyawan_id = $request->karyawan_id;
        $tanggal = $request->tanggal;
        $keterangan = $request->keterangan;
        $date = date("Y-m-d");
        $time = date("H:i:s");
        
        // Carbon::setLocale('id');
        // $jam = Carbon::now()->format('H:i:s');
        // $time = date("H:i:s"); 
        // dd($time);
        // for($i=0; $i<count($karyawan_id); $i++){
        //     $datasave = [
        //         'karyawan_id'=>$karyawan_id[$i],
        //         'tanggal'=>$tanggal[$i],
        //         'jam_masuk'=>$time[$i],
        //         'keterangan'=>$keterangan[$i],
        //     ];
        //     //return dd($datasave);
        //     DB::table('kehadirans')->insert($datasave);
        // }
        // toast('Absensi Sukses','success');
        // return redirect()->back();

        //dd($jam_shift);
        $absen = new Kehadiran();
        //
        //$shift = Shift::where('id', '=', );
        // Absen masuk
        if (isset($request->btnIn)) {
        // Cek double date
            $cek_double = $absen->where(['tanggal' => $date, 'karyawan_id' => $karyawan_id])->count();
            dd($cek_double);
            if ($cek_double > 0) {
                return redirect()->back();
            }
            if($jam_shift > $time)
            {    $absen->save([
                    'karyawan_id'   => $karyawan_id,
                    'tanggal'      => $date,
                    'jam_masuk'   => $time,
                    'keterangan'      => 'Alpha']);

                toast('Absensi Sukses','success');
                return redirect()->back();
            }
            else{
                $absen->save([
                    'karyawan_id'   => $karyawan_id,
                    'tanggal'      => $date,
                    'jam_masuk'   => $time,
                    'keterangan'      => $keterangan]);

                toast('Absensi Sukses','success');
                return redirect()->back();
            }
        } 

        // Absen keluar
        elseif (isset($request->btnOut)) {
            $absen->where(['tanggal' => $date, 'karyawan_id' => $karyawan_id])
                ->update([
                    'jam_keluar'   => $time]);
            return redirect()->back();
        }

        //return $request->all();
        /*$query[] = DB::table('karyawans')->where('id', $request->input('karyawan_id'))->get();
        $query[] = Karyawan::all();

        foreach ($query as $row) {
            //dd($row);
            $data[] = array(
                /*'keterangan' => $request->input('keterangan'),
                'tanggal' => $request->input('tanggal'),
                'karyawan_id' => $request->input('karyawan_id')*/
                /*'karyawan_id' => $request['karyawan_id'],
                'keterangan' => $request['keterangan'],
                'tanggal' => $request['tanggal'],
            );
            dd($data);
            //var_dump($data);
            DB::table('kehadirans')->insert($data); 
        }
        return view('kehadiran.index');*/

        /*$data = $request->all();
        $finalArray = array();
        foreach($data as $key=>$value){
            array_push( $finalArray, array(
                'keterangan'=>$value['keterangan'],
                'tanggal'=>$value['tanggal'],
                'karyawan_id'=>$value['karyawan_id']
            ));
        };
        dd($finalArray);
        Kehadiran::insert($finalArray);
        return view('kehadiran.index');*/

        /*$keterangan = $request->get('keterangan');
        $tanggal = $request->get('tanggal');
        $karyawan_id = $request->get('karyawan_id');*/
    }

    public function simpan_absen(Request $request)
    {
        $this->validate($request, [
            'karyawan_id' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        $karyawan_id = $request->karyawan_id;
        // $tanggal = $request->tanggal;
        // $keterangan = $request->keterangan;
        $date = date("Y-m-d");
        $time = date("H:i:s");

        $data = new Kehadiran();

        //$data->karyawan_id = $request->get('karyawan_id');
        // $data->tanggal = $request->get('tanggal');
        // $data->keterangan = $request->get('keterangan');

        // $data->save();
        // Absen masuk
        if ($request->btnIn == 'masuk') {
        // Cek double date
            $cek_double = $data->where(['tanggal' => $date, 'karyawan_id' => $karyawan_id])->count();
            //dd($cek_double);
            if ($cek_double > 0) {
                return redirect()->back();
            }
            
            $data->karyawan_id = $request->get('karyawan_id');
            $data->tanggal = $request->get('tanggal');
            $data->keterangan = $request->get('keterangan');
            $data->jam_masuk = $time;

            $data->save();

            //dd($data);
            toast('Absensi Masuk Sukses','success');
            return redirect()->back();
        } 

        // Absen keluar
        elseif ($request->btnOut == 'keluar') {
            $data->where(['tanggal' => $date, 'karyawan_id' => $karyawan_id])
                ->update([
                    'jam_keluar'   => $time]);

            toast('Absensi Keluar Sukses','success');
            return redirect()->back();
        }

        // dd($data);
        // return redirect()->back();
        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bulan_ini = Carbon::now()->format('F');
        $data['title'] = "Data Kehadiran Karyawan bulan $bulan_ini";
        
        $data['karyawans'] = Karyawan::where('id', '=', $id)->get();
        
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        // $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        // $formatted = $today->toIso8601String();
        // dd($formatted);
        $data['kehadirans'] = Kehadiran::select()
                ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
                ->whereRaw('month(kehadirans.tanggal) = '.$bulan.'')
                ->whereRaw('year(kehadirans.tanggal) = '.$tahun.'')
                ->where('kehadirans.karyawan_id', '=', $id)
                ->get();
        $data['no'] = 1;
        //$createdAt = Carbon::parse($data['kehadirans']['kehadirans.tanggal']);
        //dd($data);
        return view('kehadiran.detail', $data);
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

    public function list_karyawan(){
        $get = $_GET['data'];
        $data = DB::table('karyawans')->where('nama', 'like', "%$get%")->get();
        //$data = Pelanggan::where('nama', 'like', "%$get%")->get();
    
        if($get == null){
            Alert::error('gagal', 'anda harus daftar!');
        }
        else{
            $output = "<ul class='ul-karyawan'>";
            if(count($data) != 0){
                foreach($data as $row){
                    $output .= "<li class='li-karyawan'>".$row->id_karyawan. " - " .$row->nama."</li>";
                }
            }
            echo $output;
        }
    }

    public function check_in(Request $request){
        //$users = User::all();
        //$alpha = false;

        /*if (date('l') == 'Saturday' || date('l') == 'Sunday') {
            return redirect()->back()->with('error','Hari Libur Tidak bisa Check In');
        }

        foreach ($users as $user) {
            $absen = Kehadiran::whereUserId($user->id)->whereTanggal(date('Y-m-d'))->first();
            if (!$absen) {
                $alpha = true;
            }
        }
        
        if ($alpha) {
            foreach ($users as $user) {
                if ($user->id != $request->user_id) {
                    Kehadiran::create([
                        'keterangan'    => 'Alpha',
                        'tanggal'       => date('Y-m-d'),
                        'user_id'       => $user->id
                    ]); 
                }
            }
        }*/
        //$data['id_karyawan'] = Karyawan::find($request->id_karyawan);
        //$kehadiran = $request->jam_masuk;
        //$kehadiran = Kehadiran::whereKaryawan_Id($request->karyawan_id)->whereTanggal(date('Y-m-d'))->first();
        /*if ($kehadiran) {
            if ($kehadiran->keterangan == 'Alpha') {
                $data['jam_masuk']  = date('H:i:s');
                $data['tanggal']    = date('Y-m-d');
                $data['user_id']    = $request->user_id;
                if (strtotime($data['jam_masuk']) >= strtotime('07:00:00') && strtotime($data['jam_masuk']) <= strtotime('08:00:00')) {
                    $data['keterangan'] = 'Masuk';
                } else if (strtotime($data['jam_masuk']) > strtotime('08:00:00') && strtotime($data['jam_masuk']) <= strtotime('17:00:00')) {
                    $data['keterangan'] = 'Telat';
                } else {
                    $data['keterangan'] = 'Alpha';
                }
                $kehadiran->update($data);
                return redirect()->back()->with('success','Check-in berhasil');
            } else {
                return redirect()->back()->with('error','Check-in gagal');
            }
        }*/

        $data['jam_masuk']  = date('H:i:s');
        $data['tanggal']    = date('Y-m-d');
        $data['keterangan']    = $request->keterangan;
        $data['karyawan_id']    = $request->id_karyawan;
        /*if (strtotime($data['jam_masuk']) >= strtotime('07:00:00') && strtotime($data['jam_masuk']) <= strtotime('08:00:00')) {
            $data['keterangan'] = 'Masuk';
        } else if (strtotime($data['jam_masuk']) > strtotime('08:00:00') && strtotime($data['jam_masuk']) <= strtotime('17:00:00')) {
            $data['keterangan'] = 'Telat';
        } else {
            $data['keterangan'] = 'Alpha';
        }*/
        
        Kehadiran::create($data);
        return redirect()->back()->with('success','Check-in berhasil');
    }

    public function check_out(Request $request){
        $data['jam_keluar'] = date('H:i:s');
        $kehadiran->update($data);
        return redirect()->back()->with('success', 'Check-out berhasil');
    }
}
