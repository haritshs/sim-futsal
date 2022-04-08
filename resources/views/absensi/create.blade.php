@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Tambah Data Absensi</strong>
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
            <form action="{{ route('absensi.store') }}" method="POST" class="" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Nama Karyawan</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <select name="karyawan_id" id="select" class="form-control">
                            @foreach($karyawans as $kr)
                            <option value="{{ $kr->id }}">{{ $kr->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Bulan</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="bulan" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Tahun</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="tahun" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Hadir</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="jml_hadir" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Alfa</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="jml_alfa" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Izin</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="jml_izin" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Sakit</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="jml_sakit" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Lembur</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="jml_lembur" placeholder="" class="form-control">
                    </div>
                </div>
                
                
                <input type="submit">
            </form>
        </div>
    </div>
</div>
@endsection