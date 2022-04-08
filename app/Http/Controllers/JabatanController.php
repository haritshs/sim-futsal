<?php

namespace App\Http\Controllers;

use App\Jabatan;
use App\Pendapatan;
use App\Potongan;
use App\Admin;
use App\Shift;
use Auth;
use Pusher;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\BookSuccess;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Jabatan";
        //$data['menu'] = 3;
        $data['jabatans'] = Jabatan::all();
        $data['shift'] = Shift::all();
        //$data['admins'] = Admin::select('name')->get();
        //$data['admins'] = Admin::where('id', '!=', Auth::guard('admin')->user()->id)->get();
        //$data['pendapatans'] = Pendapatan::all();
        //$data['potongans'] = Potongan::all();
        //dd($data);
        $data['no'] = 1;
        return view('jabatan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Jabatan";
        //$data['menu'] = 3;
        return view('jabatan.create', $data);
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
            'jabatan' => 'required',
            'gaji_pokok' => 'required',
            'insentif' => 'required',
        ]);

        $data = new Jabatan();

        $data->jabatan = $request->get('jabatan');
        $data->gaji_pokok = $request->get('gaji_pokok');
        $data->insentif = $request->get('insentif');

        //$data->save();
        if ($data->save()) {

            //$admin = Admin::where('id', '!=', Auth::guard('admin')->user()->id)->get();
            $admin = Admin::select('id')->get();
            if (\Notification::send($admin, new BookSuccess(Jabatan::latest('id')->first() ))) {
            }
            $options = array(
                'cluster' => \Config::get('pusher.pusher_cluster'),
                'encrypted' => true
            );
            $pusher = new Pusher\Pusher(
                \Config::get('pusher.pusher_key'),
                \Config::get('pusher.pusher_secret'),
                \Config::get('pusher.pusher_app_id'),
                $options
            );

            $data['message'] = 'Tambah Data baru';
            $pusher->trigger('booking-baru', 'booking-baru-notif', $data);
            toast('Sukses Tambah Data','success');
            return redirect('admin/jabatan');
            
        }else{
            toast('Gagal Tambah Data','error');
            return redirect('admin/jabatan');
        }

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        
    }

    public function notification()
    {
        return Auth::guard('admin')->user()->unreadNotifications;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit Jabatan";
        $data['jabatans'] = Jabatan::find($id);
        return view('jabatan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'jabatan' => 'required',
            'gaji_pokok' => 'required',
            'insentif' => 'required',
        ]);

        if($this) {
            $update = Jabatan::find($id)->update($request->toArray());
            toast('Sukses Edit Data','success');
            return redirect('admin/jabatan');
        } else {
            toast('Gagal Edit Data','error');
            return redirect('admin/jabatan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Jabatan::destroy($id);
        return redirect('admin/jabatan');
    }

    public function update_pendapatan(Request $request, $id)
    {
        $this->validate($request,[
            'uang_lembur' => 'required',
            'uang_makan' => 'required',
            'uang_tunjangan' => 'required',
        ]);

        if($this) {
            $update = Pendapatan::find($id)->update($request->toArray());
            return redirect()->route('jabatan.index');
        } else {
            return redirect()->route('jabatan.index');
        }
    }

    public function update_potongan(Request $request, $id)
    {
        $this->validate($request,[
            'p_alfa' => 'required',
            'p_izin' => 'required',
            'p_sakit' => 'required',
            'p_cuti' => 'required',
        ]);

        if($this) {
            $update = Potongan::find($id)->update($request->toArray());
            return redirect()->route('jabatan.index');
        } else {
            return redirect()->route('jabatan.index');
        }
    }
}
