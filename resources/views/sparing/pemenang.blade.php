@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Pilih Pemenang</strong>
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
            
            <form action="{{ route('pemenang_sparing.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputState">Pilih Tim</label>
                    <select id="idtim" name="tim_id" class="form-control">
                        <option selected>Choose...</option>
                        <option value="{{ $sparings->tim_id }}">{{ $sparings->tim_id }} - {{ $sparings->tim->nama_team }} </option>
                        @foreach($lawans as $row)
                        <option value="{{ $row->tim_id }}"> {{ $row->tim_id }} - {{ $row->tim->nama_team }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputState">Pilih Pembayaran</label>
                    <select id="inputState" name="hadiah_pemenang" class="form-control">
                        <option selected>Choose...</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="">Skor</label>
                        <input type="text" name="pesan" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="">Upload Bukti</label>
                        <input type="file" name="bukti_transfer" class="file-hidden" accept="image/*" class="form-control-file">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="">Nama Pengirim</label>
                        <input type="text" name="nama_pengirim" class="form-control" id="" placeholder="">
                    </div>
                </div>
                <input type="hidden" name="sparing_id" value="{{ $sparings->id }}">
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