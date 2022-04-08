@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Lapangan</strong>
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
            <form action="{{ route('pengeluaran.update', ['id' => $pengeluarans->id]) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Nama</label>
                        <input type="text" required name="nama" value="{{ $pengeluarans->nama }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Jumlah</label>
                        <input type="text" required name="jumlah" value="{{ $pengeluarans->jumlah }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Total Biaya</label>
                        <input type="text" required name="total" value="{{ $pengeluarans->total }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Keterangan</label>
                        <input type="text" required name="keterangan" value="{{ $pengeluarans->keterangan }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Tanggal</label>
                        <input type="date" required name="tanggal" value="{{ $pengeluarans->tanggal }}" class="form-control">
                    </div>
                </div>
                <!-- <div class="form-group">
                    <div class="col col-sm-20">
                        @if($pengeluarans->foto_bukti!=null)
                        <img src="{{asset('template/images/pengeluaran/'.$pengeluarans->foto_bukti)}}" width="250" class="img-prev img-thumbnail">
                        @endif
                        <input type="file" name="foto_bukti" class="file-hidden" accept="image/*">
                    </div>
                </div> -->
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