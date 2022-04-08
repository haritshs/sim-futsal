<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Primavera Futsal</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template2/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap4.css')}}">
  <!-- datepicker -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <link rel="stylesheet"  href="{{ asset('main/assets/css/jquery.bracket.min.css') }}" />
  <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
  </script>
  @if(!Auth::guard('admin')->guest())
      <script>
      window.Laravel.adminId = {!!Auth::guard('admin')->user()->id!!}
      </script>
  @endif

  @yield('chart')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini">
  <div id="app">
    <div class="wrapper">
      <!-- Navbar -->
      
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      @include('layouts.navbar')
      @include('layouts.sidebar')

      <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">{{ $title }}</h1>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </section>
          <!-- /.content-header -->
          @yield('content')
          <!-- Main content -->
          
          <!-- /.content -->
        </div>
      <!-- /.content-wrapper -->

      @include('layouts.footer')
      <!-- Main Footer -->
    </div>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{asset('js/app.js')}}"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE -->
  <script src="{{ asset('template2/dist/js/adminlte.min.js') }}"></script>
  <!-- DataTables -->
  <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('plugins/datatables/dataTables.bootstrap4.js') }}"></script>
  <!-- bracket -->
  <script src="{{ asset('main/js/jquery.bracket.min.js') }}"></script>
  <!-- OPTIONAL SCRIPTS -->
  <!--<script src="{{ asset('template2/dist/js/demo.js') }}"></script>
  <script src="{{ asset('template2/dist/js/pages/dashboard3.js') }}"></script>-->
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <!-- <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('75dc878b3b79708a0906', {
      cluster: 'ap1',
      encrypted: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('booking-submitted', function(data) {
      alert(JSON.stringify(data));
    });
  </script> -->
  <script>
    $( function(){
        $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true,
        changeMonth: true, yearRange: '1945:'+(new Date).getFullYear() });
        $( "#datepickers" ).datepicker({ dateFormat: 'yy-mm-dd', changeYear: true,
        changeMonth: true, yearRange: '1945:'+(new Date).getFullYear() });
        });
  </script>
  @yield('script')
  <script>
    var t;
    /*function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $(input).prev().attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }*/

    function pesan_notif(data) {
      if (Notification.permission !== "granted")
        Notification.requestPermission();
      else {
        var notification = new Notification('Notification title', {
          title: data.title,
          body: data.message,
        });

        notification.onclick = function () {
          window.location.href = data.href;
        };
      }
    }
    $(document).ready( function () {
      $('#myTable').DataTable();

      /*$(".file-hidden").change(function() {
        readURL(this);
      });*/

      $(".img-prev").click(function(){
        $(this).next().click();
      })

      Pusher.logToConsole = true;

      // Initiate the Pusher JS library
      var pusher = new Pusher('75dc878b3b79708a0906', {
        cluster: 'ap1',
        encrypted: true
      });

      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('booking-baru');

      // Bind a function to a Event (the full Laravel class)
      channel.bind('booking-baru-notif', function(data) {
        console.log(data);
        var obj = {
          title: 'Booking Baru',
          message : data.message,
          href: '{{ url('/admin/booking') }}'
        }
        pesan_notif(obj);
        if(t){
          t.ajax.reload();
        }

          // this is called when the event notification is received...
      });

      /*channel.bind('new-order-confirmed', function(data) {
        console.log(data);
        var obj = {
          title: 'Booking Dibayar',
          message : data.message,
          image : '{{ url('main/img/logo-notif.jpg') }}',
          href: '{{ url('/admin/booking') }}'
        }
        notifyMe(obj);
        if(t){
          t.ajax.reload();
          // $('.sid_'+obj.id).trigger('click');
        }
          // this is called when the event notification is received...
      });*/

      if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.');
        return;
      }

      if (Notification.permission !== "granted"){
        Notification.requestPermission();
      }

      setInterval(function()
      {
          $.ajax({
              type: "get",
              url: "{{ url('/api/check-booking') }}",
              success:function(data)
              {
                  //console.log the response
                  // console.log(data);
              }
          });
      }, 60000);


      //App.init();
      //App.formElements();
    });
  </script>
  
  @stack('scripts')
  @include('sweetalert::alert')
  
</body>
</html>
