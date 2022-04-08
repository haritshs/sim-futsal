@extends('layouts.main')
@section('content')

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Info</h2>
          <p>Daftar Turnamen</p>
        </div>

        <div class="row">

          @foreach($turni as $row)
          <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
            <div class="box featured" data-aos="zoom-in" data-aos-delay="300">
              <h3>{{ $row['judul'] }}</h3>
              <img src="{{ asset('template/images/turnamen/'.$row->foto_logo) }}" alt="" style="width:200px;height:180px;">
              <br>
              <p>Total Hadiah</p>
              <h4><sup>Rp</sup>{{ number_format($row['total_hadiah']) }}<span></span></h4>
              <ul>
                <li>Slot {{ $row['slot_tim'] }} Tim</li>
                <li><b> Tanggal Mulai </b></li>
                <li>{{ $row['tanggal_mulai'] }}</li>
              </ul>
              <div class="btn-wrap">
                <a href="{{ url('/detail_turnamen/'.$row->id) }}" class="btn-buy">Detail Turnamen</a>
              </div>
            </div>
          </div>
          @endforeach

          

        </div>

      </div>
    </section>
    <!--<section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4" data-aos="fade-right">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Lokasi:</h4>
                <p>JL. Raya Menganti No. 88, Kota SBY</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Telepon:</h4>
                <p>0832 1232 2331</p>
              </div>

            </div>

          </div>

          <<div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">

            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section>-->

  </main><!-- End #main -->
@endsection