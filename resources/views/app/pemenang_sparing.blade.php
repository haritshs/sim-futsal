@extends('layouts.main')

@section('content')
<section id="pricing" class="pricing">
  <div class="container">
    <div class="section-title" data-aos="zoom-out">
        <h2>Informasi</h2>
        <p>Detail Sparing</p>
      </div>

      <div class="row">

        <div class="">
          <div class="box" data-aos="zoom-in">
            <h3>Detail  Sparing</h3>
            <h4></h4>
            @foreach($menangs as $row)
            <ul>
              <li>Tim Pemenang</li>
              <li><b>{{ $row->tim->nama_team }}</b></li>
              <li>Skor</li>
              <li><b>{{ $row->pesan }}</b></li>
              <li>Pembayaran Hadiah</li>
              <li><b>{{ $row->hadiah_pemenang }}</b></li>
              <li>Nama Pengirim</li>
              <li><b>{{ $row->nama_pengirim }}</b></li>
              <li>Foto bukti transfer</li>
              <li><img src="{{ $row->getFoto() }}"  style="width:300px;height:300px;" ></li>
            </ul>
            @endforeach
          </div>
        </div>
      </div>
  </div>
</section>
<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->

@endsection