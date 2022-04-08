@extends('layouts.main')

@section('content')
<div id="booking-confirm" class="overlay-wrap {{$errors->any()?' show':''}}">
  <div class="overlay"></div>
    <div class="form-panel ">
      <h2>BATAS WAKTU KONFIRMASI</h2>
      <h2 class="red-color timer"></h2>
      <h2>NAMA PENGIRIM</h2>
      <form class="form-wrap" method="POST"  enctype="multipart/form-data">
      {{ csrf_field() }}
        <input type="text" name="nama_pengirim" placeholder="Nama Pengirim" required>
        <h5>BUKTI TRANSFER</h5>
        <div>
          <input type="file" name="bukti_transfer" accept="image/*" required>
        </div>
        <hr>
        <button type="submit" class="button w-100">KONFIRMASI PEMBAYARAN</button>
      </form>
    </div>
</div>

<main id="main">
  <section id="contact" class="contact">
      <div class="container">

        @if (session()->has('msg'))
            <div class="spacer"></div>
            <div class="alert alert-success">
                {{ session()->get('msg') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="spacer"></div>
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
          <div class="col-md-2">
            <h5>FILTER</h5>
            <form class="form-wrap" method="GET" action="/booking">
              <select name="lapangan">
                <option>Pilih Lapangan</option>
                @foreach($lapangan as $l)
                <option {{(isset($lapangan_id) && $lapangan_id == $l->id)?'selected':''}} value="{{$l->id}}">{{$l->nama}}</option>
                @endforeach
              </select>
              @php
                $status = [
                  'baru' => 'Belum dibayar',
                  'batal' => 'Ditolak',
                  'lunas' => 'Menunggu Verifikasi',
                  'diverifikasi' => 'Diverifikasi'
                ];
              @endphp
              <hr>
              <button type="submit">Cari</button>
            </form>
          </div>

          <div class="col-md-10">
            <div class="section-title" data-aos="zoom-out">
              <h2>Booking</h2>
              <p>Riwayat Booking</p>
            </div>

            @if($booking->isEmpty())
            <h5>DATA TIDAK ADA</h5>

            @else
            <ul class="riwayat">
              @foreach($booking as $data)
                @php
                  $lapang = $data->detail->first()->lapangan;
                  $first = $data->detail->first();
                @endphp
                <li>
                  <div class="row" >
                    <div class="col-md-4">
                      <img src="{{ asset('template/images/'.$lapang->foto) }}" class="img-thumbnail">
                    </div>
                    <div class="col-md-3">
                      <h3>{{$lapang->nama}}</h3>
                      <h5>WAKTU BOOKING:</h5>
                      {{$data->created_at}}
                      <h5>TANGGAL MAIN:</h5>
                      {{$first->tanggal_main}}
                      <h5>JAM MAIN :</h5>
                      <p>
                        @foreach($data->detail as $detail)
                          <b> ({{$detail->jam_awal}} - {{$detail->jam_akhir}})</b>
                        @endforeach
                      </p>
                      
                      @if($data->status== 'batal')
                        <p class="red-color"><b>Pesan : {{ $data->pesan_batal }}</b></p>
                      @elseif($data->status== 'lunas')
                        <p class="red-color"><b>Pesan : sudah dibayar</b></p>
                      @endif
                      
                    </div>
                    <div class="col-md-3">
                      <h3>STATUS</h3>
                      <span class="statusUpdate {{$data->status}}">
                        @if($data->status == 'baru')
                          Belum Dibayar
                        @endif
                        @if($data->status == 'proses')
                          Proses
                        @endif
                        @if($data->status == 'diverifikasi')
                          Sudah Diverifikasi
                        @endif
                        @if($data->status == 'lunas')
                          Menunggu Verifikasi
                        @endif
                        @if($data->status == 'batal')
                          Ditolak
                        @endif
                      </span>
                    </div>
                    <div class="col-md-2">


                      <h3 class="text-center">AKSI</h3>
                      @if($data->status == 'baru')
                        <a href="{{ url('/booking/pembayaran/'.$data->id) }}" data-json="{{json_encode($data)}}" class="detailButton">BAYAR</a>
                        <a href="{{ url('/booking/batal_booking/'.$data->id) }}" class="button m-10 button-max-120" class="cancelButton">BATAL</a>
                      @elseif($data->status == 'diverifikasi')
                        <a href="{{ url('/booking/pembayaran/'.$data->id) }}" data-json="{{json_encode($data)}}" class="detailButton" >DETAIL</a>
                      @else
                        <a href="{{ url('/update_status/'.$data->id) }}" data-json="{{json_encode($data)}}" class="detailButton" >DETAIL</a>
                      @endif


                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
            @endif
          </div>
        </div>
      </div>
  </section>
</main>
@endsection

@section('script')

@endsection
