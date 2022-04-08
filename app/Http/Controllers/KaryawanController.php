<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;
use App\Jabatan;
use RealRashid\SweetAlert\Facades\Alert;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Karyawan";
        //$data['menu'] = 3;
        $data['karyawans'] = Karyawan::all();
        $data['no'] = 1;
        return view('karyawan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Karyawan";
        $data['jabatans'] = \App\Jabatan::all();
        //$data['menu'] = 3;
        return view('karyawan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$this->validate($request,[
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'jenkel' => 'required',
        ]);*/
        $this->validate($request, [
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'jenkel' => 'required',
            'foto_profil' => 'required|file|max:5000',
            'foto_ktp' => 'required|file|max:5000',
            'jabatan_id' => 'required',
        ]);

        //$lapangans = Lapangan::create($request->all());

        $foto_profil = "";
        $foto_ktp = "";
        if($request->hasfile('foto_profil') || $request->hasfile('foto_ktp'))
        {
            $file = $request->file('foto_profil');
            $foto_profil = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/karyawan/', $foto_profil);

            $file2 = $request->file('foto_ktp');
            $foto_ktp = time().'.'.$file2->extension();
            $file2->move(public_path().'/template/images/karyawan/', $foto_ktp);
        }
        /*else if($request->hasfile('foto_ktp'))
        {
            $file2 = $request->file('foto_ktp');
            $foto_ktp = time().'.'.$file2->extension();
            $file2->move(public_path().'/template/images/karyawan/', $foto_ktp);
        }*/

        $data = new Karyawan();

        $data->nama = $request->get('nama');
        $data->telepon = $request->get('telepon');
        $data->alamat = $request->get('alamat');
        $data->jenkel = $request->get('jenkel');
        $data->jabatan_id = $request->get('jabatan_id');
        $data->foto_profil = $foto_profil;
        $data->foto_ktp = $foto_ktp;

        if($data->save())
        {
            toast('Sukses Tambah Data','success');
            return redirect('admin/karyawan');
        }
        else
        {
            toast('Gagal Tambah Data','error');
            return redirect('admin/karyawan');
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
        //$data['menu'] = 4;
        $data['jabatans'] = Jabatan::all();
        $data['title'] = "Edit Karyawan";
        $data['karyawans'] = Karyawan::find($id);
        return view('karyawan.edit', $data);
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
        $this->validate($request,[
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'jenkel' => 'required',
            'foto_profil' => 'required',
            'foto_ktp' => 'required',
            'jabatan_id' => 'required',
        ]);

        /*if($this) {
            $update = Karyawan::find($id)->update($request->toArray());
            return redirect()->route('karyawan.index');
        } else {
            return redirect()->route('karyawan.index');
        }*/

        $karyawans = Karyawan::findOrFail($id);

        $foto_profil = $karyawans->foto_profil;
        $foto_ktp = $karyawans->foto_ktp;
        if($request->hasfile('foto_profil') || $request->hasfile('foto_ktp'))
        {
            if (File::exists(public_path().'/template/images/karyawan/'.$foto_profil) || File::exists(public_path().'/template/images/karyawan/'.$foto_ktp)) {
                File::delete(public_path().'/template/images/karyawan/'.$foto_profil);
                File::delete(public_path().'/template/images/karyawan/'.$foto_ktp);
            }

            $file = $request->file('foto_profil');
            $foto_profil = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/karyawan/', $foto_profil);

            $file2 = $request->file('foto_ktp');
            $foto_ktp = time().'.'.$file2->extension();
            $file2->move(public_path().'/template/images/karyawan/', $foto_ktp);
        }
        /*else if($request->hasfile('foto_ktp'))
        {
            if (File::exists(public_path().'/template/images/karyawan/'.$foto_ktp)) {
                File::delete(public_path().'/template/images/karyawan/'.$foto_ktp);
            }

            $file2 = $request->file('foto_ktp');
            $foto_ktp = time().'.'.$file2->extension();
            $file2->move(public_path().'/template/images/karyawan/', $foto_ktp);
        }*/

        $karyawans->nama = $request->get('nama');
        $karyawans->telepon = $request->get('telepon');
        $karyawans->alamat = $request->get('alamat');
        $karyawans->jenkel = $request->get('jenkel');
        $karyawans->jabatan_id = $request->get('jabatan_id');
        $karyawans->foto_profil = $foto_profil;
        $karyawans->foto_ktp = $foto_ktp;

        //$karyawans->update();
        if ($karyawans->update()) {
            toast('Sukses Ubah Data','success');
            return redirect('admin/karyawan');
        }else{
            toast('Gagal Ubah Data','error');
            return redirect('admin/karyawan');
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
        Karyawan::destroy($id);
        //return redirect()->route('karyawan.index');
        return redirect('admin/karyawan');
    }
}
