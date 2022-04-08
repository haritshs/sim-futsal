<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tim;
use App\Sparing;
use App\User;
use App\Lapangan;
use App\BookingDetail;
use App\Booking;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Input;

class TimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Tim";
        //$data['menu'] = 3;
        $data['no'] = 1;
        $data['tims'] = Tim::all();
        return view('tim.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Tim";
        //$data['tims'] = Tim::all();
        //dd($data);
        return view('tim.create', $data);
    }

    public function daftar_tim(Request $request)
    {
        //$data['title'] = "Tambah Tim";
        //$data['tims'] = Tim::all();
        $id = Auth::user()->id;
        $data['tims'] = Tim::where('user_id', $id)->get();
        $data['sparings'] = Sparing::with('lawan')->where('user_id', $id)->get();
        // $date = Carbon::now();
        // $date->subDays(2);
        // $data['sparings'] = Sparing::with('lawan')->with('booking')->whereDate('tgl_main', '>', $date)->get();
        $data['lapangans'] = Lapangan::all();

        //$idlapang = Input::get('pilihlapang');
        $idlapang = 1;
        //dd($idlapang);
        $data['jadwals'] = $this->jadwal_lapangan($idlapang,date('Y-m-d'));
        $data['idlapang'] = $idlapang;
        /*if($request->session()->has('idlapangan')) {
            //$idlapang = $request->session()->get('idlapangan');
            $data['jadwals'] = $this->jadwal_lapangan($idlapang,date('Y-m-d'));
            $request->session()->forget('idlapangan');
        }else{
            //$data['idlapang'] = 0;
        }*/
        //$data['tims'] = DB::table('tims')->whereRaw('user_id = ', $id);
        //dd($data);
        return view('app.tim', $data);
    }

    public function jadwal_lapangan($id, $tanggal){
        $dataArr = [];
        for ($i=7; $i <21 ; $i++) {
            $data = BookingDetail::where([['tanggal_main',$tanggal],['jam_awal', $i],['lapangan_id', $id]])->get();
            if($data->count()==0){
            $dataArr[] = (object) array('jam' => $i ,'status'=>true ,'display' => "$i - ".($i+1));
            }else{
            $book = Booking::find($data->first()->booking_id);
            if($book->status == 'batal'){
                $dataArr[] = (object) array('jam' => $i ,'status'=>true ,'display' => "$i - ".($i+1));
            }else{
                $dataArr[] = (object) array('jam' => $i ,'status'=>false ,'display' => "$i - ".($i+1));
            }
            }
        }
        return $dataArr;
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
            'nama_team' => 'required',
            'nama_kapten' => 'required',
            'deskripsi' => 'required',
            'domisili' => 'required',
            'logo' => 'required|file|max:5000',
            'user_id' => 'required',
        ]);*/
        /*$tims = Tim::create($request->all());
        if($request->hasFile('logo')){
            $request->file('logo')->move('template/images/tim/',$request->file('logo')->getClientOriginalName());
            $tims->logo = $request->file('logo')->getClientOriginalName();
            $tims->save();
        }

        if($tims){
            //$insert = Karyawan::create($request->toArray());
            return redirect()->route('app.daftar_tim');
        }
        else{
            return redirect()->route('app.daftar_tim');
        }*/
        $logo = "";
        if($request->hasfile('logo'))
        {
            $file = $request->file('logo');
            $logo = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/tim/', $logo);
        }

        $data = new Tim();
        $user_id = Auth::user()->id;

        $data->nama_team = $request->get('nama_team');
        $data->nama_kapten = $request->get('nama_kapten');
        $data->domisili = $request->get('domisili');
        $data->deskripsi = $request->get('deskripsi');
        $data->user_id = $user_id;
        $data->logo = $logo;

        //$data->save();

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        //return redirect('tim');
        if($data->save()){
            alert()->success('Sukses','Sukses Daftar Tim');
            //$request->session()->flash('msg', "Sukses Tambah Data Tim");
        }else{
            alert()->error('Gagal','Gagal Daftar Tim');
            //$request->session()->flash('err', "Gagal Tambah Data Tim");

        }
        return redirect()->route('daftar-tim');
    }

    public function buat_team(Request $request)
    {
        $this->validate($request, [
            'nama_team' => 'required',
            'nama_kapten' => 'required',
            'deskripsi' => 'required',
            'domisili' => 'required',
            'logo' => 'required|file|max:5000',
            'user_id' => 'required',
        ]);
        $logo = "";
        if($request->hasfile('logo'))
        {
            $file = $request->file('logo');
            $logo = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/tim/', $logo);
        }

        $data = new Tim();
        $id_user = Auth::user()->id;

        $data->nama_team = $request->get('nama_team');
        $data->nama_kapten = $request->get('nama_kapten');
        $data->deskripsi = $request->get('deskripsi');
        $data->domisili = $request->get('domisili');
        $data->user_id = $id_user;
        $data->logo = $logo;

        //$data->save();

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        //return redirect('tim');
        if($data->save()){
            $request->session()->flash('msg', "Sukses Tambah Data Tim");
        }else{
            $request->session()->flash('err', "Gagal Tambah Data Tim");

        }
        return redirect()->route('/daftar-tim');
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
        $data['title'] = "Edit Tim";
        $data['tims'] = Tim::find($id);
        return view('tim.edit', $data);
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
            'nama_team' => 'required',
            'nama_kapten' => 'required',
            'deskripsi' => 'required',
            'domisili' => 'required',
            'logo' => 'required',
        ]);
        $tims = Tim::findOrFail($id);

        $foto = $tims->logo;
        if($request->hasfile('logo'))
        {
            if (File::exists(public_path().'/template/images/tim/'.$foto)) {
                File::delete(public_path().'/template/images/tim/'.$foto);
            }

            $file = $request->file('logo');
            $foto = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/tim/', $foto);
        }

        $tims->nama_team = $request->get('nama_team');
        $tims->nama_kapten = $request->get('nama_kapten');
        $tims->deskripsi = $request->get('deskripsi');
        $tims->domisili = $request->get('domisili');
        $tims->logo = $foto;

        //$tims->update();
        if ($tims->update()) {
            toast('Sukses Ubah Data','success');
            return redirect('admin/tim');
        }else{
            toast('Gagal Ubah Data','error');
            return redirect('admin/tim');
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
        Tim::destroy($id);
        return redirect('admin/tim');
    }
}
