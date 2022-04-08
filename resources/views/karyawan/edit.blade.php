@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Karyawan</strong>
        </div>
        <div class="card-body card-block">
            @foreach ($errors->all() as $error)
            <h4>{{ $error }}</h4>
            @endforeach
            @if (session('status'))
            <div>
            {{ session('status') }}
            </div>
            @endif
            <form action="{{ route('karyawan.update', ['id' => $karyawans->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Nama</label>
                        <input type="text" placeholder="nama" required name="nama" value="{{ $karyawans->nama }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Telepon</label>
                        <input type="text" placeholder="" required name="telepon" value="{{ $karyawans->telepon }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Alamat</label>
                        <input type="text" placeholder="" required name="alamat" value="{{ $karyawans->alamat }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Jabatan</label>
                        <select name="jabatan_id" id="select" class="form-control">
                            @foreach($jabatans as $jb)
                            <option value="{{ $jb->id }}">{{ $jb->jabatan }}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Jenis Kelamin</label>
                        <select name="jenkel" id="select" class="form-control">
                            <option value="0">Please select</option>
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col col-sm-20">
                        @if($karyawans->foto_profil != null)
                        <img src="{{asset('template/images/karyawan/'.$karyawans->foto_profil)}}" width="250" class="img-prev img-thumbnail">
                        @endif
                        <input type="file" name="foto_profil" class="file-hidden" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        @if($karyawans->foto_ktp != null)
                        <img src="{{asset('template/images/karyawan/'.$karyawans->foto_ktp)}}" width="250" class="img-prev img-thumbnail">
                        @endif
                        <input type="file" name="foto_ktp" class="file-hidden" accept="image/*">
                    </div>
                </div>
                <input type="submit">
            </form>
        </div>
        <!--<div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Submit
            </button>
            <button type="reset" class="btn btn-danger btn-sm" href="{{ route('karyawan.index') }}">
                <i class="fa fa-ban"></i> Back
            </button>
        </div>-->
    </div>
</div>
@endsection