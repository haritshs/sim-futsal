@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Shift</strong>
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
            <form action="{{ route('shift.update', ['id' => $shifts->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <input type="text" required name="nama_shift" value="{{ $shifts->nama_shift }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <input type="time" required name="jam_masuk" value="{{ $shifts->jam_masuk }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <input type="time" required name="jam_keluar" value="{{ $shifts->jam_keluar }}" class="form-control">
                    </div>
                </div>
                
                <input type="submit">
            </form>
        </div>
    </div>
</div>
@endsection