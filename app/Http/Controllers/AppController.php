<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\BookingDetail;
use App\PendaftaranTurnamen;
use App\Lapangan;
use App\Turnamen;
use App\Tim;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AppController extends Controller
{
    public function index()
    {
      $data['turni'] = Turnamen::all();
      return view('app.index', $data);
    }

    public function detail_turnamen($id)
    {
      $data['turnamens'] = Turnamen::findOrFail($id);
      $iduser = Auth::user()->id;
      $data['tims'] = Tim::where('user_id', $iduser)->get();
      $data['jumlah_tim'] = PendaftaranTurnamen::where('turnamen_id', $id)->count();
      $data['daftar'] = PendaftaranTurnamen::where('turnamen_id', $id)->where('user_id', $iduser)->get();
      //$data['id'] = floor(time()-999999999);
      //$data['id'] = random_int(100000, 999999);
      //dd($data);
      return view('app.detail_turnamen', $data);
    }

    public function daftar_turnamen(Request $request, $id)
    {
      /*$this->validate($request, [
          'turnamen_id' => 'required',
          'tim_id' => 'required',
          'user_id' => 'required',
      ]);*/
      $iddaftar = random_int(100000, 999999);

      $turni = Turnamen::findOrFail($id);
      $userid = Auth::user()->id;
      //dd($turni);
      $daftar = new PendaftaranTurnamen();
      $daftar->id = $iddaftar;
      $daftar->turnamen_id = $id;
      $daftar->tim_id = $request->get('tim_id');
      $daftar->user_id = $userid;

      if($turni->biaya_daftar == 0)
      {
        $daftar->status = 'lunas';
      }else{
        $daftar->status = 'tunggu';
      }

      //$daftar->save();
      if($daftar->save()){
        //$request->session()->flash('msg', "Sukses Daftar Sparing");
        alert()->success('Sukses','Sukses Daftar Turnamen');
      }else{
          //$request->session()->flash('err', "Gagal Daftar Sparing");
          alert()->error('Error','Gagal Daftar Turnamen');
      }
      return redirect()->back();
    }


    public function lapangan()
    {
      $data = Lapangan::all();
      return view('app.lapangan', ['lapangan'=>$data]);
    }

    public function tampil_lapangan($id){
      $data['lapangans'] = Lapangan::findOrFail($id);
      $data['jadwal'] = $this->jadwal_lapangan($id,date('Y-m-d'));
      //$data['jadwal2'] = $this->jadwal_lapangan2($id,date('Y-m-d'));
      $userid = Auth::user()->id;
      $data['tims'] = Tim::where('user_id', $userid)->get();
      //dd($data);
      //return view('app.detail_lapangan', ['id'=>$id, 'lapangans'=>$data, 'jadwal'=>$jadwal, 'tims'=>$tims] );
      return view('app.detail_lapangan', ['id'=>$id], $data);
    }

    public function jadwal_lapangan($id, $tanggal){
      $dataArr = [];
      for ($i=7; $i <23 ; $i++) {
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

    // public function jadwal_lapangan2($id, $tanggal){
    //   $dataArr = [];
    //   for ($i=7; $i <23 ; $i++) {
    //     $data = BookingDetail::where([['tanggal_main',$tanggal],['jam_awal', $i],['lapangan_id', $id]])->get();
    //     if($data->count()==0){
    //       $dataArr[] = (object) array('jam2' => $i ,'status2'=>true ,'display2' => "$i - ".($i+1));
    //     }else{
    //       $book = Booking::find($data->first()->booking_id);
    //       if($book->status == 'batal'){
    //         $dataArr[] = (object) array('jam2' => $i ,'status2'=>true ,'display2' => "$i - ".($i+1));
    //       }else{
    //         $dataArr[] = (object) array('jam2' => $i ,'status2'=>false ,'display2' => "$i - ".($i+1));
    //       }
    //     }
    //   }
    //   return $dataArr;
    // }

    public function galeri()
    {
      return view('app.galeri');
    }

    public function futsal()
    {
      return view('app.futsal');
    }

    public function buatTim(Request $request)
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

        $data->nama_team = $request->get('nama_team');
        $data->nama_kapten = $request->get('nama_kapten');
        $data->deskripsi = $request->get('deskripsi');
        $data->domisili = $request->get('domisili');
        $data->user_id = Auth::user()->id;
        $data->logo = $logo;

        if($data->save()){
            $request->session()->flash('msg', "Sukses Tambah Data Tim");
        }else{
            $request->session()->flash('err', "Gagal Tambah Data Tim");
        }
        return redirect()->route('/home');
        /*if($this) {
          $insert = Tim::create($request->toArray());
          //Alert::success('Pendaftaran Sukses!', 'Selanjutnya Silahkan Isi Formulir Booking');
          return redirect()->route('/home');
        }*/
    }
}
