<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Primavera Futsal</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('main/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('main/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('main/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('main/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
  <!-- Template Main CSS File -->
  <link href="{{ asset('main/assets/css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/mine.css') }}" rel="stylesheet">
  <!-- bracket -->
  <link rel="stylesheet"  href="{{ asset('main/assets/css/jquery.bracket.min.css') }}" />
  <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">-->
  <!-- =======================================================
  * Template Name: Selecao - v4.3.0
  * Template URL: https://bootstrapmade.com/selecao-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center  header-transparent ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index.html">Primavera Futsal</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto {{ Request::path()=='/'?'active':'' }}" href="{{ url('/') }}">Home</a></li>
          <li><a class="nav-link scrollto {{ Request::path()=='lapangan'?'active':'' }}" href="{{ url('/lapangan') }}">Jadwal Lapangan</a></li>
          <li><a class="nav-link scrollto" href="{{ url('/galeri') }}">Galeri</a></li>
          <li><a class="nav-link scrollto" href="{{ url('/futsal') }}">Futsal</a></li>
          @if(Auth::check())
          <li><a class="nav-link scrollto" href="{{ url('/booking') }}">Booking</a></li>
          <li class="dropdown"><a href="#"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('/profile') }}">Edit Profile</a></li>
              <li><a href="{{ url('/daftar-tim') }}">Daftar Tim</a></li>
              <li><a href="{{ url('/sparing') }}">Sparing</a></li>
              <li>
              <form method="POST" action="{{ url('/logout') }}">
              {{ csrf_field() }}
                <button type="submit" >Logout</buton>

              </form>
              </li>
            </ul>
          </li>
          @endif
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <section id="hero" class="d-flex flex-column justify-content-end align-items-center">
    <div id="heroCarousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="carousel-container">
          <h2 class="animate__animated animate__fadeInDown">Welcome to <span>Primavera Futsal</span></h2>
          <p class="animate__animated fanimate__adeInUp">Booking Lapangan Secara Online</p>
          <div>
          @guest
            <a href="{{ route('login') }}" class="btn-get-started animate__animated animate__fadeInUp scrollto">Login</a>
            <a href="{{ route('register') }}" class="btn-get-started animate__animated animate__fadeInUp scrollto">Register</a>
            @else
            <h6 style="color:#fff">Hallo  {{ Auth::user()->name }} , Selamat Datang di Primavera Futsal</h6>
          @endguest
          </div>
        </div>
      </div>

    </div>

    <!--<svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
      <defs>
        <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
      </defs>
      <g class="wave1">
        <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)">
      </g>
      <g class="wave2">
        <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
      </g>
      <g class="wave3">
        <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
      </g>
    </svg>-->

  </section><!-- End Hero -->

  @yield('content')
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>Primavera Futsal</h3>
      <p>Booking Lapangan Secara Online</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
      <!--<div class="copyright">
        &copy; Copyright <strong><span>Selecao</span></strong>. All Rights Reserved
      </div>-->
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/selecao-bootstrap-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('main/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('main/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('main/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('main/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('main/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('main/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  
  <!-- Template Main JS File -->
  <script src="{{ asset('main/assets/js/main.js') }}"></script>
  <script src="{{ asset('main/js/jquery.min.js') }}"></script>
  <script src="{{ asset('main/js/scripts.js') }}"></script>
  <script src="{{ asset('main/js/jquery.bracket.min.js') }}"></script>
  <script src="{{ asset('main/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('main/js/jquery.ba-outside-events.min.js') }}"></script>
  <script src="{{ asset('main/js/tab.js') }}"></script>
  <script src="{{ asset('main/js/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('main/js/jquery.vide.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

  <!--bootstrap-->
  <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->

  <script type="text/javascript">
  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $(input).prev().attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }
  function notifyMe(data) {
    if (Notification.permission !== "granted")
      Notification.requestPermission();
    else {
      var notification = new Notification('Notification title', {
        title: data.title,
        icon: data.image,
        body: data.message,
      });

      notification.onclick = function () {
        window.location.href = data.href;
      };

    }

  }
  $(function(){


    setInterval(function()
    {
      $.ajax({
          type: "get",
          url: "{{ url('/api/check-booking') }}",
          success:function(data)
          {
              //console.log the response
              console.log(data);
          }
      });
    }, 60000);


    $('.overlay').click(function(){
      $('.overlay-wrap').removeClass('show');
      $('.overlay-wrap').fadeOut();
    });

    $('.showModal').click(function(){
      $($(this).data('modal'))
        .css("display", "flex")
        .hide()
        .fadeIn();
    });

    $(".file-hidden").change(function() {
      readURL(this);
    });

    $(".img-prev").click(function(){
      $(this).next().click();
    });

    $(".date-picker").on("change", function() {
      this.setAttribute(
          "data-date",
          moment(this.value, "YYYY-MM-DD")
          .format( this.getAttribute("data-date-format") )
      )
    }).trigger("change");

    $('.msg').delay(2000).fadeOut();

    //NOTIF
    if (!Notification) {
      alert('Desktop notifications not available in your browser. Try Chromium.');
      return;
    }

    if (Notification.permission !== "granted"){
      Notification.requestPermission();
    }

    Pusher.logToConsole = true;

     // Initiate the Pusher JS library
    var pusher = new Pusher('67b689f1b7f71c36e781', {
      cluster: 'ap1',
      encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('new-order');


    channel.bind('order-status-change', function(data) {

      var obj = {
        message : data.message,
        image : '{{ url('main/img/logo-notif.jpg') }}',
        href: '{{ url('/admin/booking') }}'
      }
      if(data.status == 'batal'){
        obj.title = 'Order anda ditolak oleh admin.';
      }else{
        obj.title = 'Order anda diverifikasi.';
      }
      var user = {{\Auth::check()?\Auth::check():'0'}};

      if(data.user_id == user){
        notifyMe(obj);
        $.get('{{ url('/api/booking/'.\Auth::id())}}', function(data){
        }).done(function(data,err){
          $('.riwayat').empty();

          data.forEach(function(el,i){
            var lapang = el.detail[0].lapangan;
            var first = el.detail[0];
            var waktu='';
            el.detail.forEach(function(detail,i){

              waktu += `<b> (${detail.jam_awal} - ${detail.jam_akhir})</b>`;
            });
            var pesan='';

            if(el.status== 'batal'){
              if(!el.cancel_message) el.cancel_message = "";
              pesan = `<p class="red-color"><b>Pesan: ${el.cancel_message}</b></p>`;
            }else if(el.status== 'lunas'){
              pesan = `<p class="red-color"><b>Pesan: sudah dibayar</b></p>`;
            }

            var status='';
            if(el.status == 'baru') status = 'Belum dibayar';
            if(el.status == 'diverifikasi') status = 'Sudah diverifikasi';
            if(el.status == 'lunas') status = 'Menunggu Verifikasi';
            if(el.status == 'batal') status = 'Ditolak';

            var btn ='';
            if(el.status == 'baru'){
              btn = `<a href="javascript:void(0);" data-json='${JSON.stringify(el)}' data-modal='#booking-confirm' class="btnBayar showModal button blue button-max-120">BAYAR</a>
              <a href="{{ url('/booking/batal_booking/') }}${el.id}" class="button m-10 button-max-120">BATAL</a>`;
            }



            $('.riwayat').append(`
              <li>
              <div class="row" >
                <div class="col-md-4">
                  <img src="{{ asset('template/images/') }}/${lapang.foto}" class="img-thumbnail">
                </div>
                <div class="col-md-3">
                  <h3>${lapang.nama}</h3>
                  <h5>WAKTU BOOKING:</h5>
                  ${el.created_at}
                  <h5>TANGGAL MAIN:</h5>
                  ${first.tanggal_main}
                  <h5>JAM MAIN :</h5>
                  <p>${waktu}</p>
                  <p class="red-color">Total Biaya : Rp. ${(el.total_harga/1000).toFixed(3)}</p>
                  ${pesan}
                </div>
                <div class="col-md-3">
                  <h3>STATUS</h3>
                  <span class="statusUpdate status ${el.status}">
                    ${status}
                  </span>
                </div>
                <div class="col-md-2">
                  <h3 class="text-center">AKSI</h3>
                  ${btn}
                </div>
              </div>
            </li>

            `);
          });
        }).fail(function(data){
        });
      }
    });
  });
</script>
@yield('script')
@include('sweetalert::alert')
</body>

</html>