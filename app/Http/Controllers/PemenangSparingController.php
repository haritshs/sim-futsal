<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PemenangSparing;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class PemenangSparingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PemenangSparing::all();

        $arr = [
            'data' => $data
        ];
        return $arr;
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
        /*$this->validate($request, [
            'tim_id' => 'required',
            'pesan' => 'required',
            'hadiah_pemenang' => 'required',
            'bukti_transfer' => 'required',
            'nama_pengirim' => 'required',
        ]);*/

        //$turni = Sparing::findOrFail($id);
        $foto = "";
        if($request->hasfile('bukti_transfer'))
        {
            $file = $request->file('bukti_transfer');
            $foto = time().'.'.$file->extension();
            $file->move(public_path().'/template/images/pemenang/', $foto);
        }
        $pemenang = new PemenangSparing();
        $pemenang->sparing_id = $request->sparing_id;
        $pemenang->tim_id = $request->tim_id;
        $pemenang->pesan = $request->pesan;
        $pemenang->hadiah_pemenang = $request->hadiah_pemenang;
        $pemenang->nama_pengirim = $request->nama_pengirim;
        $pemenang->bukti_transfer = $foto;

        $pemenang->save();
        return redirect('admin/sparing');
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
}
