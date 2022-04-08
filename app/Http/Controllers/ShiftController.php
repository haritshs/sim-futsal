<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Data Shift Karyawan";
        $data['shift'] = Shift::all();
        $data['no'] = 1;
        return view('shift.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Data Shift";
        //$data['menu'] = 3;
        return view('shift.create', $data);
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
            'nama_shift' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        $data = new Shift();

        $data->nama_shift = $request->get('nama_shift');
        $data->jam_masuk = $request->get('jam_masuk');
        $data->jam_keluar = $request->get('jam_keluar');

        //$data->save();
        if ($data->save()) {

            toast('Sukses Tambah Data','success');
            return redirect('admin/shift');
            
        }else{
            toast('Gagal Tambah Data','error');
            return redirect('admin/shift');
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
        $data['title'] = "Edit Data Shift";
        $data['shifts'] = Shift::find($id);
        return view('shift.edit', $data);
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
            'nama_shift' => 'required',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
        ]);

        if($this) {
            $update = Shift::find($id)->update($request->toArray());
            toast('Sukses Edit Data','success');
            return redirect('admin/shift');
        } else {
            toast('Gagal Edit Data','error');
            return redirect('admin/shift');
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
        Shift::destroy($id);
        return redirect('admin/shift');
    }
}
