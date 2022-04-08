<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pertanyaan;
use App\Komentar;
use App\User;

class PertanyaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data['title'] = "Lapangan";
        //$data['menu'] = 3;
        //$data['no'] = 1;
        $data['tanya'] = Pertanyaan::all();
        $data['users'] = User::all();
        return view('app.forum', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$data['title'] = "Tambah Lapangan";
        //$data['menu'] = 3;
        return view('app.create_forum');
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
            'judul' => 'required',
            'isi' => 'required',
            'user_id' => 'required',
        ]);

        $data = new Pertanyaan();

        $data->judul = $request->get('judul');
        $data->isi = $request->get('isi');
        $data->user_id = $request->get('user_id');

        $data->save();

        //$request->session()->flash('msg', 'Data lapang berhasil ditambah');
        return redirect('pertanyaan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['tanya'] = Pertanyaan::find($id);
        return view('app.detail_forum', $data);
    }

    public function komentar_pertanyaan(Request $request, $id)
    {
        $komentar = new Komentar;
        $komentar->isi = $request->komentar;
        $komentar->user_id = auth()->user()->id;
        $komentar->pertanyaan_id = $id;
        $komentar->save();
        //Alert::success('Berhasil', 'Komentar Berhasil di tambahkan');
        return redirect('pertanyaan/' . $id);
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
