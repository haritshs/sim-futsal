@extends('layouts.main')
@section('content')

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="card">
            <div class="card-header">
                <p style="text-align: left; font-size:30px; margin-top:25px">Cari Teman / Lawan Sparingmu Disini<br>
                    <a href="{{ route('pertanyaan.create') }}" type="submit" class="btn btn-primary text-white btn-md text-dark" style="border-radius:50px; margin-bottom:25px" >Yuk Tanya</a>
                </p>
            </div>
            @foreach ($tanya as $row)
            <div class="inner-main-body pl-4 pr-4 mt-3">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="media forum-item">
                        <a href="" data-toggle="collapse" data-target=""><img src="{{asset('main/assets/img/default.jpg')}}" class="mr-3 rounded-circle" width="50" alt="User" /></a>
                            <div class="media-body">
                                <h6><a href="{{ route('pertanyaan.show',  ['id' => $row["id"]]) }}"  class="text-bold">{{ $row->judul }}</a></h6>
                                {{-- <p class="text-secondary">
                                    {!!$row->isi!!}
                                </p> --}}
                                <p class="text-muted"><a>Created </a> at <span class="text-secondary font-weight-bold">{{$row->created_at->diffForHumans()}}</span></p>
                            </div>
                            <div class="text-muted small text-center align-self-center">
                                <span><i class="far fa-comment ml-2"></i> {{$row->komentar->count()}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection