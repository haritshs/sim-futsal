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
            <h3 class="card-title">Form {{ $title }} </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('turnamen.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <p>Judul</p>
                            <input type="text" class="form-control" required name="judul" value="{{ old('judul') }}" >
                        </div>
                        <div class="form-group">
                            <p>Deskripsi</p>
                            <textarea name="deskripsi" id="" cols="30" rows="10" value="{{ old('deskripsi') }}"></textarea>
                        </div>
                        <div class="form-group">
                            <p>Slot Tim</p>
                            <input type="number" class="form-control" required name="slot_tim" value="{{ old('slot_tim') }}">
                        </div>
                        <div class="form-group">
                            <p>Total Hadiah</p>
                            <input type="number" class="form-control" required name="total_hadiah" value="{{ old('total_hadiah') }}">
                        </div>
                        <div class="form-group">
                            <p>Biaya Daftar</p>
                            <input type="number" class="form-control" required name="biaya_daftar" value="{{ old('biaya_daftar') }}">
                        </div>
                        <div class="form-group">
                            <p>Link Bracket</p>
                            <input type="text" class="form-control" required name="link_bracket" value="{{ old('link_braket') }}">
                        </div>
                        <div class="form-group">
                            <p>Tanggal Mulai</p>
                            <input type="date" class="form-control" required name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                        </div>
                        <div class="form-group">
                            <p>Tanggal Selesai</p>
                            <input type="date" class="form-control" required name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                        </div>
                        
                        <div class="form-group">
                            <p>Foto Logo</p>
                            <input type="file" class="form-control" name="foto_logo" accept="image/*">
                        </div>
                        
                    </div>
            
                </div>
                <input type="submit">
                <a href="{{ route('turnamen.index') }}">Kembali</a>
            </form>
        </div>
    </div>
</section>
@endsection