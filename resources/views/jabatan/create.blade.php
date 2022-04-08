@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Tambah Data Jabatan</strong>
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
            <form action="{{ route('jabatan.store') }}" method="POST" class="" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Jabatan</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="jabatan" placeholder="masukkan jabatan" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Gaji Pokok</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="gaji_pokok" placeholder="masukkan gaji pokok" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Insentif</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="insentif" placeholder="masukkan insentif" class="form-control">
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