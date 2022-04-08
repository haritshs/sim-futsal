@extends('layouts.main')

@section('content')
<main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Profil</h2>
          <p>Edit Profil</p>
        </div>
        
        <div class="row mt-5">

          <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">

            <form action="{{ url('/profile/'.$profile->id.'/edit') }}" method="post" role="form" class="php-email-form">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" value="{{$profile->name}}" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="{{$profile->email}}" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="no_telpon" id="no_telpon" placeholder="No Telepon" value="{{$profile->no_telpon}}" required>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="{{$profile->alamat}}" required>
              </div>
              
              <div class="text-center"><button type="submit">Simpan</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
@endsection