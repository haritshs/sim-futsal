@extends('layouts.main')

@section('content')
<section id="main">
    <div style="position: relative;min-height: 600px; overflow: hidden;">
        <div class="container">
            <div class="section-title" data-aos="zoom-out">
                <h2>Lapangan</h2>
                <p>Pilih Lapangan</p>
            </div>
            @php
            $len = count($lapangan);
            $i=0;
            @endphp
            @foreach ($lapangan as $row)
            <div class="row">
            <div class="col-md-4">
                <img src="{{asset('template/images/'.$row->foto)}}" class="img-responsive img-thumbnail">
            </div>
            <div class="col-md-6">
                <div class="box featured" data-aos="zoom-in" data-aos-delay="300">
                    <h3>Lapangan : {{ $row->nama }}</h3>
                    <h5>Jenis : {{ ucfirst($row->jenis) }}</h5>
                    <h4 class="red-color">Harga sewa : Rp. {{ number_format($row->harga_sewa,2) }} / Jam</h4>
                    <br>
                    <div class="btn-wrap">
                        <a href="{{ url('/lapangan/'.$row->id) }}" class="myButton">Detail</a>
                    </div>
                    <br>
                </div>
            </div>
            <div class="col-md-2"></div>
            </div>
            @if($i!=$len-1)
            <hr>
            @else
            <br>
            <br>
            @endif

            @php
            $i++;
            @endphp
            @endforeach
        </div>
    </div>
</section>
@endsection
