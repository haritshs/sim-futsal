<?php

namespace App\Http\Controllers;

use App\Pendapatan;
use App\Potongan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Pendapatan & Potongan Gaji";
        //$data['menu'] = 3;
        $data['pendapatans'] = Pendapatan::all();
        $data['potongans'] = Potongan::all();
        //dd($data);
        $data['no'] = 1;
        return view('pendapatan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Pendapatan & Potongan";
        //$data['menu'] = 3;
        return view('pendapatan.create', $data);
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
            'uang_lembur' => 'required',
            'uang_makan' => 'required',
            'uang_tunjangan' => 'required',
        ]);*/

        $pendapatan = new Pendapatan();
        $potongan = new Potongan();

        $pendapatan->uang_lembur = $request->get('uang_lembur');
        $pendapatan->uang_makan = $request->get('uang_makan');
        $pendapatan->uang_tunjangan = $request->get('uang_tunjangan');

        $potongan->p_alfa = $request->get('p_alfa');
        $potongan->p_izin = $request->get('p_izin');
        $potongan->p_sakit = $request->get('p_sakit');
        $potongan->p_cuti = $request->get('p_cuti');

        //$pendapatan->save();
        if ($pendapatan->save() && $potongan->save()) {
            toast('Sukses Tambah Data','success');
            return redirect('admin/pendapatan');
        }else{
            toast('Gagal Tambah Data','error');
            return redirect('admin/pendapatan');
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
        $data['title'] = "Edit Pendapatan & Potongan";
        $data['pendapatans'] = Pendapatan::find($id);
        $data['potongans'] = Potongan::find($id);
        return view('pendapatan.edit', $data);
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

    public function update_pendapatan(Request $request, $id)
    {
        $this->validate($request,[
            'uang_lembur' => 'required',
            'uang_makan' => 'required',
            'uang_tunjangan' => 'required',
        ]);

        if($this) {
            $update = Pendapatan::find($id)->update($request->toArray());
            toast('Sukses Ubah Data','success');
            return redirect()->route('pendapatan.index');
        } else {
            return redirect()->route('pendapatan.index');
        }
    }

    public function update_potongan(Request $request, $id)
    {
        $this->validate($request,[
            'p_alfa' => 'required',
            'p_izin' => 'required',
            'p_sakit' => 'required',
            //'p_cuti' => 'required',
        ]);

        if($this) {
            $update = Potongan::find($id)->update($request->toArray());
            toast('Sukses Ubah Data','success');
            return redirect()->route('pendapatan.index');
        } else {
            return redirect()->route('pendapatan.index');
        }
    }
}
