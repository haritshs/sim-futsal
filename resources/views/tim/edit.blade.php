@extends('layouts.app')

@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header">
            <strong>Edit Data Tim</strong>
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
            <form action="{{ route('tim.update', ['id' => $tims->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Nama Tim</label>
                        <input type="text" name="nama_team" value="{{ $tims->nama_team }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Nama Kapten</label>
                        <input type="text" name="nama_kapten" value="{{ $tims->nama_kapten }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Domisili</label>
                        <input type="text" name="domisili" value="{{ $tims->domisili }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col col-sm-20">
                        <label for="text-input" class=" form-control-label">Deskripsi</label>
                        <input type="text" name="deskripsi" value="{{ $tims->deskripsi }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col col-sm-20">
                        @if($tims->logo!=null)
                        <img src="{{asset('template/images/tim/'.$tims->logo)}}" width="250" class="img-prev img-thumbnail">
                        @endif
                        <input type="file" name="logo" class="file-hidden" accept="image/*">
                    </div>
                </div>
                <input type="submit">
            </form>
        </div>
    </div>
</div>
@endsection