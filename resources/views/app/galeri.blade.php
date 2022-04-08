@extends('layouts.main')

@section('content')
<section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Galeri</h2>
          <p>Foto Lapangan</p>
        </div>

        <div class="row portfolio-container" data-aos="fade-up">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="{{asset('main/assets/img/portfolio/foto1.png')}}" class="img-fluid" alt=""></div>
            
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-img"><img src="{{asset('main/assets/img/portfolio/foto2.png')}}" class="img-fluid" alt=""></div>
            
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-img"><img src="{{asset('main/assets/img/portfolio/foto3.png')}}" class="img-fluid" alt=""></div>
            
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-img"><img src="{{asset('main/assets/img/portfolio/foto4.png')}}" class="img-fluid" alt=""></div>
            
          </div>
            
        </div>

      </div>
    </section><!-- End Portfolio Section -->
@endsection