@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Tambah Data Pengeluaran</strong>
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
            <form action="{{ route('pengeluaran.store') }}" method="POST" class="" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Nama Pengeluaran</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="nama" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Jumlah</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="jumlah" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Total Biaya</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="number" id="text-input" name="total" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Keterangan</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="longtext" id="text-input" name="keterangan" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Tanggal</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="date" id="text-input" name="tanggal" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-md-3">
                        <label for="file-input" class=" form-control-label">Foto Bukti</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="file" name="foto_bukti" class="file-hidden" accept="image/*" class="form-control-file">
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