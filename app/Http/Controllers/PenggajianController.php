<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jabatan;
use App\Pendapatan;
use App\Potongan;
use App\Karyawan;
use App\Kehadiran;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Carbon;
//use Carbon\CarbonImmutable;
use Carbon\Carbon;
use PDF;

class PenggajianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['tanggal'] = Carbon::now();
        $data['title'] = "Data Penggajian";
        $data['no'] = 1;
        $data['karyawans'] = Karyawan::all();
        $data['kehadirans'] = Kehadiran::select("*")->groupBy('karyawan_id')->get();
        //$data['kehadirans'] = Kehadiran::all();
        $data['potongans'] = Potongan::all();
        $data['pendapatans'] = Pendapatan::all();
        //dd($data);

        return view('penggajian.index', $data);
    }

    public function filter(Request $request){

        // $tgl = Carbon::now();
        $data['title'] = "Data Penggajian";
        $data['no'] = 1;
        //dd($data);
        
        if (!isset($_GET['filter'])) {
            //return view('penggajian.index', $data);
            $data['b'] = $request->get('bulan');
            $data['t'] = $request->get('tahun');

            //$potongan = Potongan::all();
            //$pendapatan = Pendapatan::all();
            //dd($b);
            $data['kehadirans'] = DB::table('kehadirans')
                ->select('*')
                ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
                ->join('jabatans', 'jabatans.id', '=', 'karyawans.jabatan_id')
                ->whereMonth('kehadirans.tanggal', '=', $data['b'])
                ->whereYear('kehadirans.tanggal', '=',  $data['t'])
                ->get();
            //dd($data);
            return view('penggajian.filter', $data);
        }
            
            //return view('penggajian.index', ['gaji' => $gaji, 'bulan' => $b, 'tahun' => $t, 'pendapatan' => $pendapatan, 'potongan' => $potongan]);
        
    }

    public function detailFilter($id, $bulan, $tahun)
    {
        // $bulan = $request->bulan;
        // $tahun = $request->tahun;
        //$gaji = Kehadiran::select("*")->groupBy('karyawan_id')->get();
        //$gaji = Kehadiran::find($id);
        //dd($bulan);
        $gaji = DB::table('kehadirans')
            ->selectRaw(" *,".
            "SUM(CASE WHEN kehadirans.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS h, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS a, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Izin' THEN 1 ELSE 0 END) AS i, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS s, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Cuti' THEN 1 ELSE 0 END) AS c")
            ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
            ->join('jabatans', 'jabatans.id', '=', 'karyawans.jabatan_id')
            ->whereRaw('month(kehadirans.tanggal) = '.$bulan.'')
            ->whereRaw('year(kehadirans.tanggal) = '.$tahun.'')
            ->whereRaw('kehadirans.karyawan_id = '.$id.'')
            ->get();
        //dd($gaji);
        // Set lokasi timezone ke indonesia (ID)
        Carbon::setLocale('id');
        $tanggal = Carbon::now();
        //$slip = 'SIPK-' . rand(0, 9999);
        $slip = 'SIM-' .$id;
        $title = "Detail Gaji";

        $potongan = Potongan::first();
        $pendapatan = Pendapatan::first();

        return view('penggajian.detail_filter', [ 'bulan' => $bulan, 'tahun' => $tahun,'gaji' => $gaji, 'potongan' => $potongan, 'pendapatan' => $pendapatan, 'tanggal' => $tanggal, 'slip' => $slip, 'title' => $title]);    
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
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        //$gaji = Kehadiran::select("*")->groupBy('karyawan_id')->get();
        //$gaji = Kehadiran::find($id);
        //dd($bulan);
        $gaji = DB::table('kehadirans')
            ->selectRaw(" *,".
            "SUM(CASE WHEN kehadirans.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS h, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS a, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Izin' THEN 1 ELSE 0 END) AS i, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS s, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Cuti' THEN 1 ELSE 0 END) AS c")
            ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
            ->join('jabatans', 'jabatans.id', '=', 'karyawans.jabatan_id')
            ->whereRaw('month(kehadirans.tanggal) = '.$bulan.'')
            ->whereRaw('year(kehadirans.tanggal) = '.$tahun.'')
            ->whereRaw('kehadirans.karyawan_id = '.$id.'')
            ->get();
        //dd($gaji);
        // Set lokasi timezone ke indonesia (ID)
        Carbon::setLocale('id');
        $tanggal = Carbon::now();
        $slip = 'SIM-' .$id;
        $title = "Detail Gaji";

        $potongan = Potongan::first();
        $pendapatan = Pendapatan::first();

        return view('penggajian.show', [ 'bulan' => $bulan, 'tahun' => $tahun,'gaji' => $gaji, 'potongan' => $potongan, 'pendapatan' => $pendapatan, 'tanggal' => $tanggal, 'slip' => $slip, 'title' => $title]);
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
        $potongan = Potongan::findOrFail($id);
        $pendapatan = Pendapatan::findOrFail($id);

        if ($request->get('alfa') || $request->get('izin') || $request->get('sakit')) {
            $potongan->nm_alfa = $request->get('alfa');
            $potongan->nm_izin = $request->get('izin');
            $potongan->nm_sakit = $request->get('sakit');

            $potongan->save();

            return redirect()->route('penggajians.index', [$id])->with('status', 'Data Pengurangan Gaji berhasil diupdated');
        }

        if ($request->get('lembur') || $request->get('makan') || $request->get('tunjangan')) {

            $pendapatan->nm_lembur = $request->get('lembur');
            $pendapatan->nm_makan = $request->get('makan');
            $pendapatan->nm_tunjangan = $request->get('tunjangan');

            $pendapatan->save();

            return redirect()->route('penggajians.index', [$id])->with('status', 'Data Penambahan Gaji berhasil diupdated');
        }
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

    // fungsi print Slip Gaji PDF
    public function cetak_slip($id)
    {
        
        $potongan = Potongan::first();
        $pendapatan = Pendapatan::first();

        
        $tanggal = Carbon::now();
        $slip = 'SIM-' . $id;
        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        $title = "Detail Gaji";

        // $gaji = DB::table('karyawans')
        //     ->join('jabatans', 'karyawans.jabatan', '=', 'jabatans.jabatan')
        //     ->join('absensis', 'karyawans.id', '=', 'absensis.karyawan_id')
        //     ->where('absensis.bulan', 'LIKE', '%' . $bulan . '%')
        //     ->where('absensis.tahun', 'LIKE', '%' . $tahun . '%')
        //     ->get();

        $gaji = DB::table('kehadirans')
            ->selectRaw(" *,".
            "SUM(CASE WHEN kehadirans.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS h, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS a, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Izin' THEN 1 ELSE 0 END) AS i, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS s, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Cuti' THEN 1 ELSE 0 END) AS c")
            ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
            ->join('jabatans', 'jabatans.id', '=', 'karyawans.jabatan_id')
            ->whereRaw('month(kehadirans.tanggal) = '.$bulan.'')
            ->whereRaw('year(kehadirans.tanggal) = '.$tahun.'')
            ->whereRaw('kehadirans.karyawan_id = '.$id.'')
            ->get();

        //dd($gaji);
        set_time_limit(300);
        // fungsi cetak pdf
        //$pdf = PDF::loadview('penggajian.cetak', ['bulan' => $bulan, 'tahun' => $tahun,'gaji' => $gaji, 'potongan' => $potongan, 'pendapatan' => $pendapatan, 'tanggal' => $tanggal, 'slip' => $slip, 'title' => $title])->setOptions(['defaultFont' => 'sans-serif']);
        return view('penggajian.cetak', ['bulan' => $bulan, 'tahun' => $tahun,'gaji' => $gaji, 'potongan' => $potongan, 'pendapatan' => $pendapatan, 'tanggal' => $tanggal, 'slip' => $slip, 'title' => $title]);
        
        //dd($pdf);
        //return $pdf->stream();
        //return $pdf->download('slip-pegawai-pdf');
        //return $pdf->stream('slip_gaji' . $slip . '-' . $tahun . '.pdf');
    }

    public function cetak_detail_slip($id, $bulan, $tahun)
    {
        
        $potongan = Potongan::first();
        $pendapatan = Pendapatan::first();

        
        $tanggal = Carbon::now();
        $slip = 'SIM-' . $id;
        // $bulan = Carbon::now()->format('m');
        // $tahun = Carbon::now()->format('Y');
        $title = "Detail Gaji";

        // $gaji = DB::table('karyawans')
        //     ->join('jabatans', 'karyawans.jabatan', '=', 'jabatans.jabatan')
        //     ->join('absensis', 'karyawans.id', '=', 'absensis.karyawan_id')
        //     ->where('absensis.bulan', 'LIKE', '%' . $bulan . '%')
        //     ->where('absensis.tahun', 'LIKE', '%' . $tahun . '%')
        //     ->get();

        $gaji = DB::table('kehadirans')
            ->selectRaw(" *,".
            "SUM(CASE WHEN kehadirans.keterangan = 'Hadir' THEN 1 ELSE 0 END) AS h, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Alpha' THEN 1 ELSE 0 END) AS a, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Izin' THEN 1 ELSE 0 END) AS i, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Sakit' THEN 1 ELSE 0 END) AS s, ".
            "SUM(CASE WHEN kehadirans.keterangan = 'Cuti' THEN 1 ELSE 0 END) AS c")
            ->join('karyawans', 'karyawans.id', '=', 'kehadirans.karyawan_id')
            ->join('jabatans', 'jabatans.id', '=', 'karyawans.jabatan_id')
            ->whereRaw('month(kehadirans.tanggal) = '.$bulan.'')
            ->whereRaw('year(kehadirans.tanggal) = '.$tahun.'')
            ->whereRaw('kehadirans.karyawan_id = '.$id.'')
            ->get();

        //dd($gaji);
        //set_time_limit(300);
        // fungsi cetak pdf
        //$pdf = PDF::loadview('penggajian.cetak', ['bulan' => $bulan, 'tahun' => $tahun,'gaji' => $gaji, 'potongan' => $potongan, 'pendapatan' => $pendapatan, 'tanggal' => $tanggal, 'slip' => $slip, 'title' => $title])->setOptions(['defaultFont' => 'sans-serif']);
        return view('penggajian.cetak_detail', ['bulan' => $bulan, 'tahun' => $tahun,'gaji' => $gaji, 'potongan' => $potongan, 'pendapatan' => $pendapatan, 'tanggal' => $tanggal, 'slip' => $slip, 'title' => $title]);
        
        //dd($pdf);
        //return $pdf->stream();
        //return $pdf->download('slip-pegawai-pdf');
        //return $pdf->stream('slip_gaji' . $slip . '-' . $tahun . '.pdf');
    }
}
