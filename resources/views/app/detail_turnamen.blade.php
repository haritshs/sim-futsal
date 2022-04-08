@extends('layouts.main')
@section('content')

<section id="about" class="about">
    <div class="container">

      <div class="section-title" data-aos="zoom-out">
        <h2>Info</h2>
        <p>Detail Turnamen</p>
      </div>

      <div class="row content" data-aos="fade-up">
        <div class="col-lg-6">
          <p>
            {{ $turnamens['deskripsi'] }}
          </p>
          <ul>
            <li><i class="ri-check-double-line"></i>Biaya Pendaftaran Rp. {{ number_format($turnamens['biaya_daftar']) }}</li>
            <li><i class="ri-check-double-line"></i>Sisa Slot <b>{{ $turnamens['slot_tim']-$jumlah_tim }} Tim</b></li>
            <li><i class="ri-check-double-line"></i>Tanggal Main {{ $turnamens['tanggal_mulai'] }} s/d {{ $turnamens['tanggal_selesai'] }}</li>
          </ul>
        </div>
        
        
        @if($daftar->isEmpty())
        <div class="col-lg-6 pt-4 pt-lg-0">
          @if($tims->isEmpty())
          <p>Anda Belum Punya Tim, Daftarkan tim anda terlebih dahulu</p>
          @else
          <p>
            Daftarkan Teammu Sekarang Juga!
          </p>
          <form action="{{ route('app.daftar-turnamen', ['id' => $turnamens["id"]]) }}" method="post" >
          {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 form-group">
              @foreach($tims as $row)
              <label for="">Nama Team</label>
                  <select name="tim_id" id="select" class="form-control">
                      <option value="{{ $row['id'] }}">{{ $row['nama_team'] }}</option>
                  </select>
              @endforeach
              </div>
            </div>
            <div>
              <button type="submit">Daftar</button>
            </div>
          </form>
          @endif
          @if($turnamens['slot_tim'] == $jumlah_tim)
          <p>Pendaftaran Sudah Penuh</p>
          @endif
        </div>
        @endif
        
        @foreach($daftar as $d)
          @if($d['user_id'] == Auth::user()->id)
          <div class="col-lg-6 pt-4 pt-lg-0">
            @if($d->status == 'tunggu' && $d->user_id == Auth::user()->id && $d->turnamen->biaya_daftar != 0)
            <p>
              Proses Selanjutnya, Silahkan Lakukan Pembayaran!
            </p>
            <div>
              <a href="{{ url('/turnamen/pembayaran/'.$d->id) }}" class="detailButton">BAYAR</a>
            </div>
            @endif
            @if($d->status == 'lunas' && $d->user_id == Auth::user()->id && $d->turnamen->biaya_daftar != 0)
            <p>
              Team Anda Sudah Terdaftar!
            </p>
            <div>
              <a href="{{ url('/turnamen/pembayaran/'.$d->id) }}" class="detailButton">DETAIL</a>
            </div>
            @endif
            @if($d->status == 'lunas' && $d->user_id == Auth::user()->id && $d->turnamen->biaya_daftar == 0)
            <p>
              Team Anda Sudah Terdaftar!
            </p>
            @endif
          </div>
          @endif
        @endforeach
      </div>

      @if($turnamens['link_bracket'] != null)
      <div class="card">
        <h4>BRACKET</h4>
        <iframe src="{{ $turnamens['link_bracket'] }}" width="100%" height="500" frameborder="0" scrolling="auto" allowtransparency="true"></iframe>
      </div>
      @endif
      

    </div>
</section>
  
  @include('app.pendaftaran_turnamen')
@endsection

@section('script')
<script type="text/javascript">
  var minData = {
    teams: [
      ["Team 1", "Team 2"],
      ["Team 3", null],
      ["Team 4", null],
      ["Team 5", null]
    ],
    results: [
        [
          [[1, 0], [null, null], [null, null], [null, null]],
          [[null, null], [1, 4]],
          [[null, null], [null, null]]
        ]
    ]
  };
  $(function() {
    $('.turnamenBracket').bracket({
      init: minData /* data to initialize the bracket with */ })
  });
</script>
@endsection