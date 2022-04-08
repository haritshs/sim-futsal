@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Tambah Data Tim</strong>
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
            <form action="{{ route('tim.store') }}" method="POST" class="" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Nama Tim</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="nama_team" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Leader</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="nama_kapten" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">domisili</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="domisili" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">deskripsi</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="deskripsi" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">User ID</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="" name="user_id" placeholder="" class="form-control">
                    </div>
                </div>
                
                
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="file-input" class=" form-control-label">Foto Logo</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="file" name="logo" class="file-hidden" accept="image/*" class="form-control-file">
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