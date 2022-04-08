<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lapangan;
use RealRashid\SweetAlert\Facades\Alert;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Lapangan";
        //$data['menu'] = 3;
        $data['no'] = 1;
        $data['lapangans'] = Lapangan::all();
        return view('lapangan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Lapangan";
        //$data['menu'] = 3;
        return view('lapangan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$validatedData = $request->validate([
            'nama' => 'required|max:255',
            'jenis' => 'required',
            'deskripsi' => 'required',
            'harga_sewa' => 'required|numeric',
            'foto' => 'required|file|max:5000',
        ]);*/
        $this->validate($request, [
            'nama' => 'required|max:255',
            'jenis' => 'required',
            'deskripsi' => 'required',
            'harga_sewa' => 'required|numeric',
            'foto' => 'required|file|max:5000',
        ]);

        //$lapangans = Lapangan::create($request->all());

        $foto = "";
        if($request->hasfile('foto'))
        {
            $file = $request->file('foto');
            $foto = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/', $foto);
        }

        $data = new Lapangan();

        $data->nama = $request->get('nama');
        $data->deskripsi = $request->get('deskripsi');
        $data->jenis = $request->get('jenis');
        $data->harga_sewa = $request->get('harga_sewa');
        $data->foto = $foto;

        //$data->save();
        if($data->save())
        {
            toast('Sukses Tambah Data','success');
            return redirect('admin/lapangan');
        }
        else
        {
            toast('Gagal Tambah Data','error');
            return redirect('admin/lapangan');
        }

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        
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
        $data['title'] = "Edit Lapangan";
        $data['lapangans'] = Lapangan::find($id);
        return view('lapangan.edit', $data);
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
        /*$validatedData = $request->validate([
            'nama' => 'required|max:255',
            'jenis' => 'required',
            'deskripsi' => 'required',
            'harga_sewa' => 'required|numeric',
        ]);*/
        $this->validate($request, [
            'nama' => 'required|max:255',
            'jenis' => 'required',
            'deskripsi' => 'required',
            'harga_sewa' => 'required|numeric',
            'foto' => 'required',
        ]);
        $lapangans = Lapangan::findOrFail($id);

        $foto = $lapangans->foto;
        if($request->hasfile('foto'))
        {
            if (File::exists(public_path().'/template/images/'.$foto)) {
                File::delete(public_path().'/template/images/'.$foto);
            }

            $file = $request->file('foto');
            $foto = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/', $foto);
        }

        $lapangans->nama = $request->get('nama');
        $lapangans->deskripsi = $request->get('deskripsi');
        $lapangans->jenis = $request->get('jenis');
        $lapangans->harga_sewa = $request->get('harga_sewa');
        $lapangans->foto = $foto;

        //$lapangans->update();
        if ($lapangans->update()) {
            toast('Sukses Ubah Data','success');
            return redirect('admin/lapangan');
        }else{
            toast('Gagal Ubah Data','error');
            return redirect('admin/lapangan');
        }

        //$request->session()->flash('msg', 'Data lapang berhasil diubah');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lapangan::destroy($id);
        //return redirect()->route('lapangan.index');
        return redirect('admin/lapangan');
    }
}
