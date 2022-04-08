<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengeluaran;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Pengeluaran Tambahan";
        $data['pengeluarans'] = Pengeluaran::all();
        $data['no'] = 1;
        return view('pengeluaran.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Pengeluaran";
        return view('pengeluaran.create', $data);
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
            'nama' => 'required',
            'jumlah' => 'required',
            'total' => 'required',
            'keterangan' => 'required',
            'foto_bukti' => 'required|file|max:5000',
            'tanggal' => 'required',
        ]);

        $foto_bukti = "";
        if($request->hasfile('foto_bukti'))
        {
            $file = $request->file('foto_bukti');
            $foto_bukti = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/pengeluaran/', $foto_bukti);

        }

        $data = new Pengeluaran();

        $data->nama = $request->get('nama');
        $data->jumlah = $request->get('jumlah');
        $data->total = $request->get('total');
        $data->keterangan = $request->get('keterangan');
        $data->tanggal = $request->get('tanggal');
        $data->foto_bukti = $foto_bukti;

        if($data->save())
        {
            toast('Sukses Tambah Data','success');
            return redirect('admin/pengeluaran');
        }
        else
        {
            toast('Gagal Tambah Data','error');
            return redirect('admin/pengeluaran');
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
        $data['title'] = "Edit Pengeluaran";
        $data['pengeluarans'] = Pengeluaran::find($id);
        return view('pengeluaran.edit', $data);
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
            'nama' => 'required',
            'jumlah' => 'required',
            'total' => 'required',
            'keterangan' => 'required',
            //'foto_bukti' => 'required|file|max:5000',
            'tanggal' => 'required',
        ]);
        $data = Pengeluaran::findOrFail($id);

        $foto = $data->foto_bukti;
        if($request->hasfile('foto_bukti'))
        {
            if (File::exists(public_path().'/template/images/pengeluaran/'.$foto)) {
                File::delete(public_path().'/template/images/pengeluaran/'.$foto);
            }

            $file = $request->file('foto_bukti');
            $foto = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/pengeluaran/', $foto);
        }

        $data->nama = $request->get('nama');
        $data->jumlah = $request->get('jumlah');
        $data->total = $request->get('total');
        $data->keterangan = $request->get('keterangan');
        $data->tanggal = $request->get('tanggal');
        $data->foto_bukti = $foto;

        
        if ($data->update()) {
            toast('Sukses Ubah Data','success');
            return redirect('admin/pengeluaran');
        }else{
            toast('Gagal Ubah Data','error');
            return redirect('admin/pengeluaran');
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
        Pengeluaran::destroy($id);
        //return redirect()->route('lapangan.index');
        return redirect('admin/pengeluaran');
    }
}
