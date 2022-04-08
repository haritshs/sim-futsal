@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Tambah Data Lapangan</strong>
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
            <form action="{{ route('voucher.store') }}" method="POST" class="" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="text-input" class=" form-control-label">Kode</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input type="text" id="text-input" name="kode" placeholder="" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="select" class=" form-control-label">Tipe</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <select name="tipe" id="select" class="form-control">
                            <option value="0">Please select</option>
                            <option value="nominal">Nominal</option>
                            <option value="persen">Persen</option>
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="textarea-input" class=" form-control-label">Nominal Voucher</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input min="0" step="1" name="nominal_diskon" rows="9" placeholder="" class="form-control"></input>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col col-md-3">
                        <label for="textarea-input" class=" form-control-label">Diskon</label>
                    </div>
                    <div class="col-12 col-md-9">
                        <input min="0" step="1" name="persen_diskon" rows="9" placeholder="" class="form-control"></input>
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