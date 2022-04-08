@extends('layouts.main')


@section('content')
<div style="position: relative;min-height: 600px; overflow: hidden;margin-bottom: 50px;">
  <div style="margin-top: 150px;" class="container text-center">
      <h2>Pendaftaran Sparing Berhasil</h2>
      <h5>Selanjutnya Silahkan Melakukan Pembayaran</h5>
      <h3>TOTAL BIAYA :</h3>
      <h1 class="red-color">
        Rp. {{ number_format($booking->total_harga,2) }}
      </h1>
      
      <br>
      <h5>Silahkan Melakukan Pembayaran</h5>
      @php
        $lapang = $booking->detail->first()->lapangan;
      @endphp
      <a href="{{ url('/booking/?lapangan='.$lapang->id.'&status=baru') }}" class="button">Konfirmasi</a>
      <a href="/" class="button">Nanti</a>
  </div>
</div>

@endsection

@section('script')


@endsection
