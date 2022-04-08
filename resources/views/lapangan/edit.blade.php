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
            <form action="{{ route('lapangan.update', ['id' => $lapangans->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Nama</label>
                        <input type="text" placeholder="nama" required name="nama" value="{{ $lapangans->nama }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Deskripsi</label>
                        <input type="text" placeholder="deskripsi" required name="deskripsi" value="{{ $lapangans->deskripsi }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="select" class=" form-control-label">Jenis</label>
                        <select name="jenis" id="select" class="form-control">
                            <option value="0">Please select</option>
                            <option value="sintetis">Sintetis</option>
                            <option value="karet">Karet</option>
                            <option value="plester">Plester</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Harga Sewa</label>
                        <input type="text" placeholder="" required name="harga_sewa" value="{{ $lapangans->harga_sewa }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        @if($lapangans->foto!=null)
                        <img src="{{asset('template/images/'.$lapangans->foto)}}" width="250" class="img-prev img-thumbnail">
                        @endif
                        <input type="file" name="foto" class="file-hidden" accept="image/*">
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