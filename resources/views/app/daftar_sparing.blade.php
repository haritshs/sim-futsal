@extends('layouts.main')
@section('content')

  <main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Info</h2>
          <p>Daftar Sparing</p>
        </div>
        @if(\Session::has('msg'))
        <p class="status w-100 success">
            {{\Session::get('msg')}}
        </p>
        @endif

        @if(\Session::has('err'))
        <p class="status w-100 canceled">
            {{\Session::get('err')}}
        </p>
        @endif

        <div class="row mt-5">

          <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">

            <form action="{{ route('sparing.store') }}" method="post" >
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
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <label for="">Tanggal Main</label>
                  <input type="date" class="form-control" name="tgl_main" id="" placeholder="Tanggal Main" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="">Hadiah Yang Di Berikan</label>
                <input type="number" class="form-control" name="total_hadiah" id="" placeholder="Rp. " required>
              </div>
              <div>
                <button type="submit">Kirim</button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </section>
    

  </main><!-- End #main -->
@endsection