@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Voucher</strong>
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
            <form action="{{ route('voucher.update', ['id' => $vouchers->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="" class=" form-control-label">Kode</label>
                        <input type="text" placeholder="" required name="kode" value="{{ $vouchers->kode }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="select" class=" form-control-label">Tipe</label>
                        <select name="tipe" id="select" class="form-control">
                            <option value="0">Please select</option>
                            <option value="nominal">Nominal</option>
                            <option value="persen">Persen</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="" class=" form-control-label">Nominal</label>
                        <input type="number" placeholder="" required name="nominal_diskon" value="{{ $vouchers->nominal_diskon }}" class="form-control">
                    </div>
                </div>
                
                <input type="submit">
            </form>
        </div>
    </div>
</div>
@endsection