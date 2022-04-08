<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Turnamen;
use App\Bracket;
use App\PendaftaranTurnamen;
use RealRashid\SweetAlert\Facades\Alert;

class TurnamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Turnamen";
        //$data['menu'] = 3;
        $data['no'] = 1;
        $data['turni'] = Turnamen::all();
        return view('turnamen.index', $data);
    }

    public function save_bracket(Request $request)
    {
        //$bracket = Bracket::create($request->all());
        
        $brackets = array(
            "teams" => [
                ["Team 1","Team 2"],
                ["Team 3","Team 4"],
                ["Team 5","Team 6"],
                ["Team 7","Team 8"]
            ],
            "results" => [
                [
                    [
                        ["1","0"],
                        ["4","6"],
                        ["2","3"],
                        ["1","0"]
                    ],
                    [
                        ["4","3"],
                        ["2","1"]
                    ],
                    [
                        ["2","1"],
                        ["2","3"]
                    ]
                ]
            ]
        );

        foreach($brackets as $a)
        {    
            foreach($a as $b=>$c)
            {
                $string .= $c.',';
            }
        }
        //$result = implode(",", $brackets);
        $result = substr($string,0,-1);
        dd($result);

        $data = Bracket::insert($brackets);
       
        if($data->save()){
            //$insert = Karyawan::create($request->toArray());
            toast('Sukses Simpan Data','success');
            return redirect()->route('turnamen.index');
        }
        else{
            toast('Gagal Simpan Data','error');
            return redirect()->route('turnamen.index');
        }
        return ['code' => 0, 'message' => 'Error']; 
        //return view('turnamen.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = "Tambah Turnamen";
        //$data['menu'] = 3;
        return view('turnamen.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $turni = Turnamen::create($request->all());
        if($request->hasFile('foto_logo')){
            $request->file('foto_logo')->move('template/images/turnamen',$request->file('foto_logo')->getClientOriginalName());
            $turni->foto_logo = $request->file('foto_logo')->getClientOriginalName();
            $turni->save();
        }

        if($turni){
            //$insert = Karyawan::create($request->toArray());
            return redirect()->route('turnamen.index');
        }
        else{
            return redirect()->route('turnamen.index');
        }
    }

    public function daftar_turnamen(Request $request, $id)
    {
        $this->validate($request, [
            'turnamen_id' => 'required',
            'nama_team' => 'required',
            'user_id' => 'required',
        ]);

        //status jika tanpa biaya daftar langsung lunas
        $turni = Turnamen::findOrFail($id);
        $daftar = new PendaftaranTurnamen();
        $daftar->turnamen_id = $turni->id;
        $daftar->nama_team = $request->nama_team;
        $daftar->user_id = Auth::user()->id;

        $daftar->save();
        return redirect('app/turnamen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = "Data Peserta Turnamen";
        //$data['menu'] = 3;
        $data['no'] = 1;
        $data['daftar'] = PendaftaranTurnamen::where('turnamen_id', $id)->get();
        return view('turnamen.detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['title'] = "Edit Turnamen";
        $data['turni'] = Turnamen::find($id);
        return view('turnamen.edit', $data);
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
        $turni = Turnamen::find($id);
        $turni->update($request->all());
        if($request->hasFile('foto_logo')){
            $request->file('foto_logo')->move('template/images/turnamen/',$request->file('foto_logo')->getClientOriginalName());
            $turni->foto_logo = $request->file('foto_logo')->getClientOriginalName();
            $turni->save();
        }
        
        if($turni){
            Alert::toast('Sukses Edit Data Turnamen', 'success');
            return redirect()->route('turnamen.index');
        } else {
            Alert::toast('Gagal Edit Data Turnamen', 'warning');
            return redirect()->route('turnamen.index');
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
        Turnamen::destroy($id);
        return redirect()->route('turnamen.index');
    }
}
