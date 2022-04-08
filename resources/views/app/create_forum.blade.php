@extends('layouts.main')
@section('content')

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="card-header">
            <h3 class="card-title text-dark">Masukan pertanyaan anda</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('pertanyaan.store') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group">
                    <label for="judul">Masukan Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Masukan Pertanyaan Anda</label>
                    <textarea name="isi" id="isi" class="form-control my-editor"></textarea>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                </div>
                
                <a href="/" type="submit" class="btn btn-light mt-3">kembali</a>
                <button type="submit" class="btn btn-light mt-3">Submit</button>
            </div>
            <!-- /.card-body -->
        </form>
        
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection