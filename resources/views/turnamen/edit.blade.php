@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Turnamen</strong>
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
            <form action="{{ route('turnamen.update', ['id' => $turni->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Judul</label>
                        <input type="text" placeholder="judul" required name="judul" value="{{ $turni->judul }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Deskripsi</label>
                        <input type="text" placeholder="deskripsi" required name="deskripsi" value="{{ $turni->deskripsi }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Slot Tim</label>
                        <input type="number" placeholder="" required name="slot_tim" value="{{ $turni->slot_tim }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Total Hadiah</label>
                        <input type="number" placeholder="" required name="total_hadiah" value="{{ $turni->total_hadiah }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Biaya Daftar</label>
                        <input type="number" placeholder="" required name="biaya_daftar" value="{{ $turni->biaya_daftar }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Link Bracket</label>
                        <input type="text" placeholder="" name="link_bracket" value="{{ $turni->link_bracket }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="text-input" class=" form-control-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" required name="tanggal_mulai" value="{{ $turni->tanggal_mulai }}">
                </div>
                <div class="form-group">
                    <label for="text-input" class=" form-control-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" required name="tanggal_selesai" value="{{ $turni->tanggal_selesai }}">
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        @if($turni->foto_logo!=null)
                        <img src="{{asset('template/images/turnamen/'.$turni->foto_logo)}}" width="250" class="img-prev img-thumbnail">
                        @endif
                        <input type="file" name="foto_logo" class="file-hidden" accept="image/*">
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