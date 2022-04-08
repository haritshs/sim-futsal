@extends('layouts.app')

@section('content')
<section class="content col-md-6">

    @if ($errors->any())
        
        @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
           
    @endif

    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title">Form {{$title}} </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('karyawan.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Nama</p>
                            <input type="text" class="form-control" required name="nama" value="{{ old('nama') }}" >
                        </div>
                        <div class="form-group">
                            <p>Jabatan</p>
                            <select name="jabatan_id" id="select" class="form-control">
                            @foreach($jabatans as $jb)
                            <option value="{{ $jb->id }}">{{ $jb->jabatan }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                            <p>No Telepon</p>
                            <input type="number" class="form-control" required name="telepon" value="{{ old('telepon') }}">
                        </div>
                        <div class="form-group">
                            <p>Alamat</p>
                            <input type="text" class="form-control" required name="alamat" value="{{ old('alamat') }}">
                        </div>
                        <div class="form-group">
                            <p>Jenis Kelamin</p>
                            <select name="jenkel" id="select" class="form-control">
                                <option value="">Pilih</option>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col col-md-3">
                                <label for="file-input" class=" form-control-label">Foto Profil</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" name="foto_profil" class="file-hidden" accept="image/*" class="form-control-file">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col col-md-3">
                                <label for="file-input" class=" form-control-label">Foto Ktp</label>
                            </div>
                            <div class="col-12 col-md-9">
                                <input type="file" name="foto_ktp" class="file-hidden" accept="image/*" class="form-control-file">
                            </div>
                        </div>
                    </div>
            
                </div>
                <input type="submit">
                <a href="{{ route('karyawan.index') }}">Kembali</a>
            </form>
        </div>
    </div>
</section>
@endsection