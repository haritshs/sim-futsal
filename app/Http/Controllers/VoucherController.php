<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Voucher";
        //$data['menu'] = 3;
        $data['vouchers'] = Voucher::all();
        //dd($data);
        $data['no'] = 1;
        return view('voucher.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Voucher";
        //$data['menu'] = 3;
        return view('voucher.create', $data);
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
            'kode' => 'required',
            'tipe' => 'required',
            'nominal_diskon' => 'required',
            'nominal_persen' => 'required',
        ]);*/

        $data = new Voucher();

        $data->kode = $request->get('kode');
        $data->tipe = $request->get('tipe');
        $data->nominal_diskon = $request->get('nominal_diskon');
        //$data->persen_diskon = $request->get('persen_diskon');

        //$data->save();
        if ($data->save()) {
            toast('Sukses Tambah Data','success');
            return redirect('admin/voucher');
        }else{
            toast('Gagal Tambah Data','error');
            return redirect('admin/voucher');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit Voucher";
        $data['vouchers'] = Voucher::find($id);
        return view('voucher.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'kode' => 'required',
            'tipe' => 'required',
            'nominal_diskon' => 'required',
        ]);

        if($this) {
            $update = Voucher::find($id)->update($request->toArray());
            toast('Sukses Edit Data','success');
            return redirect()->route('voucher.index');
        } else {
            toast('Gagal Edit Data','error');
            return redirect()->route('voucher.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Voucher::destroy($id);
        toast('Sukses Hapus Data','error');
        return redirect()->route('voucher.index');
    }
}
