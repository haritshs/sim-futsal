@extends('layouts.main')
@section('content')

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="card">
            <div class="card-header">
                <p style="text-align: left; font-size:30px; margin-top:25px">Cari Teman / Lawan Sparingmu Disini</p>
            </div>
            <div class="card-header">
                <div class="user-block">
                <img class="img-circle" src="{{asset('main/assets/img/default.jpg')}}" alt="User Image" style="width:50px;height:50px;">
                <span class="username"><a>{{ $tanya->user->name }}</a></span>
                <span class="description">{{ $tanya->created_at->diffForHumans() }}</span>
                </div>
                <!-- /.user-block -->
                <div class="card-tools">
                <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle text-dark" data-toggle="dropdown">
                    <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                        <a href="" class="dropdown-item">Edit</a>
                        <form action="" method="POST">
                            <input type="submit" value="Delete" class="dropdown-item btn btn-light btn-sm">
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- post text -->
            <p>{{ $tanya->isi }}</p>
            <!-- Attachment -->
            <!-- /.attachment-block -->

            <!-- Social sharing buttons -->
            <span class="float-right text-muted">{{ $tanya->komentar->count()}} comments</span>
        </div>
        <!-- /.card-body -->
        @foreach ($tanya->komentar as $row)
            <div class="card-footer card-comments">
                <div class="card-comment">
                <!-- User image -->
                <img class="img-circle img-sm" src="{{asset('main/assets/img/default.jpg')}}" alt="User Image" style="width:50px;height:50px;">

                <div class="comment-text">
                    <span class="username">
                    {{$row->user->name}}
                    <span class="text-muted float-right">{{$row->created_at->diffForHumans()}}</span>
                    </span><!-- /.username -->
                    {{$row->isi}}
                </div>
                <!-- /.comment-text -->
                </div>
            </div>
        @endforeach
        <!-- /.card-footer -->
        <div class="card-footer">
            <form action="{{ route('pertanyaan.komentar_pertanyaan',  ['id' => $tanya["id"]]) }}" method="POST">
            {{ csrf_field() }}
                <img class="img-fluid img-circle img-sm" src="{{asset('main/assets/img/default.jpg')}}" alt="Alt Text" style="width:50px;height:50px;">
                <!-- .img-push is used to add margin to elements next to floating images -->
                <div class="img-push">
                    <input type="text" name="komentar" class="form-control form-control-sm" placeholder="Press enter to post comment">
                </div>
            </form>
        </div>
        <!-- /.card-footer -->
        </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection