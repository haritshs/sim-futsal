@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Jabatan</strong>
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
            <form action="{{ route('jabatan.update', ['id' => $jabatans->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <input type="text" placeholder="jabatan" required name="jabatan" value="{{ $jabatans->jabatan }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <input type="number" placeholder="gaji_pokok" required name="gaji_pokok" value="{{ $jabatans->gaji_pokok }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <input type="number" placeholder="insentif" required name="insentif" value="{{ $jabatans->insentif }}" class="form-control">
                    </div>
                </div>
                
                <input type="submit">
            </form>
        </div>
    </div>
</div>
@endsection