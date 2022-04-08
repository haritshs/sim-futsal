@extends('layouts.main')
@section('content')
<div id="daftar-sparing" class="overlay-wrap {{$errors->any()?' show':''}}">
  <div class="overlay"></div>
  <div class="form-panel ">
    @guest
    <div class="text-center">
      <h3>HARAP LOGIN TERLEBIH DAHULU</h3>
      <a href="{{ url('/') }}" class="button">HOME</a>
    </div>
    @else
      <h3>DAFTAR SPARING</h3>
      <br>
      <div class="form-wrap">
        <form method="POST" action="">
        {{ csrf_field() }}
          @php
            $hour = \Carbon\Carbon::now('Asia/Jakarta')->hour;
          @endphp
          @if($errors->any())
            @foreach($errors->all() as $error)
              <p class="red-color err">{{ $error }}</p>
            @endforeach
          @else
            <label class="red-color err"></label>
          @endif
          @foreach($tims as $t)
            @if($tims)
            
            <label for="">Masukkan Nama Team</label>
            <select name="tim_id" id="select" class="form-control" placeholder="Pilih Tim Anda">
              <option value="" disabled selected>Select your Team</option>
              <option value="{{ $t['id'] }}">{{ $t['nama_team'] }}</option>
            </select>
            <label for="">Hadiah Bagi Pemenang (boleh kosong)</label>
            <input type="number" name="total_hadiah" placeholder="Rp." min="0">
            
            @endif
          @endforeach
          <br>
          <label class="text-left">Tanggal Main</label>
          <input id="main-date" name="tanggal_main" type="date" data-date="" data-date-format="DD/MM/YYYY" class="date-picker" value="{{ date("Y-m-d") }}">
          <br>
          <label class="text-left">Jam Main</label>
          <div class="waktu">
            @php
              $i=0;
            @endphp
            @foreach ($jadwals as $row)
              @if($row->status)
                @if($hour < $row->jam)
                  <div class="jam">
                    <input type="checkbox" id="jam_{{$i}}" name='jam[]' value="{{$row->jam}}">
                    <label for="jam_{{$i}}">{{$row->display}}</label>
                  </div>
                  @php
                    $i++;
                  @endphp
                @endif
              @endif

            @endforeach

            @if($i==0)
              <label class="red-color">Tempat sudah tutup</label>
            @endif

          </div>
          <hr>
          <button  type="submit" class="proses-book button w-100">PROSES BOOKING</button>
        </form>
      </div>
    @endguest
  </div>
</div>

<section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Info</h2>
          <p>Tim Futsal Anda</p>
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
          
          @if (!empty($tims))
          <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
            @foreach($tims as $row)
            <div class="box featured" data-aos="zoom-in" data-aos-delay="300">
              <h3>{{ $row['nama_team']}}</h3>
              <img src="{{ asset('template/images/tim/'.$row->logo) }}" alt="" style="width:200px;height:180px;">
              <br>
              <p>Kapten</p>
              <h4>{{ $row['nama_kapten']}}</h4>
              <ul>
                <li>{{ $row['deskripsi']}}</li>
                <li>Domisili {{ $row['domisili']}}</li>
              </ul>
              <div class="btn-wrap">
                <a href="{{ route('lapangan') }}" class="btn-buy">Daftar Sparing</a>
                <!-- <button type="submit" data-modal='#daftar-sparing' class="showModal">Daftar Sparing</button> -->
              </div>
            </div>
            @endforeach
          </div>
          @endif

          <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">
            
            @if($tims->isEmpty())
            <form action="{{ route('tim.tambah-team') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="nama_team" class="form-control" id="" placeholder="Nama Team" required>
                </div>
                <div class="col-md-6 form-group">
                  <input type="text" name="nama_kapten" class="form-control" id="" placeholder="Nama Kapten/Leader" required>
                </div>
                
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="domisili" id="" placeholder="Domisili/Asal Team" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="deskripsi" id="" rows="5" placeholder="Deskripsi Team" required></textarea>
              </div>
              <div class="form-group mt-3">
                <label for="">Upload Logo Team</label>
                <input type="file" name="logo" class="" accept="image/*" class="form-control">
              </div>
              
              <button type="submit">Simpan</button>
            </form>
            @endif
            <br>

            @if($sparings->isEmpty())
            <div class="col-md-10">

              <h4>DATA TIDAK ADA SPARING</h4>

              @else
              <ul class="riwayat">
                @foreach($sparings as $row)
                  <li>
                    <div class="row" >
                      
                      <div class="col-md-3">
                        <h3>NEXT MATCH</h3>
                        <img src="{{ asset('template/images/tim/'.$row->tim->logo) }}" style="width:100px;height:100px;">
                        <p><b>{{ $row->tim->nama_team }}</b></p>
                        <h4>vs</h4>
                        @foreach($row->lawan as $row2)
                        <img src="{{ asset('template/images/tim/'.$row2->tim->logo) }}" style="width:100px;height:100px;">
                        <p><b>{{ $row2->tim->nama_team }}</b></p>
                        
                        @endforeach
                        
                      </div>
                      <div class="col-md-6">
                        <h3>INFO</h3>
                        <h5>HADIAH:</h5>
                        <p><b>Rp. {{ number_format($row->total_hadiah) }}</b></p>
                        <h5>TANGGAL MAIN:</h5>
                        <p><b>{{ $row->tgl_main }}</b></p>
                        <h5>JAM MAIN :</h5>
                        <p><b>19-20</b></p>
                        
                      </div>
                      <div class="col-md-3">
                        <h3>AKSI</h3>
                        
                      </div>
                    </div>
                  </li>
                @endforeach
              </ul>
            </div>
            @endif
          </div>
        </div>
      </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">
  
  $(function(){
    $('#main-date').change(function(){
      var id = {{$idlapang}};
      //var id = document.getElementById("pilihlapang")[0].id;
      //var id = $('#pilihlapang :selected')..val();
      var date = $(this).val();
      var dif1 = new Date(date);
      var dif2 = new Date();
      dif1.setHours(0,0,0,0);
      dif2.setHours(0,0,0,0);
      if(dif1<dif2){
        $('.err').html('Tanggal tidak boleh kurang dari hari ini!');

        $(this).val(`${dif2.getFullYear()}-${('0'+(dif2.getMonth() + 1)).slice(-2)}-${('0'+dif2.getDate()).slice(-2)}`);
        $(this).attr('data-date', `${('0'+dif2.getDate()).slice(-2)}/${('0'+(dif2.getMonth() + 1)).slice(-2)}/${dif2.getFullYear()}`);
      }else if(dif2.addDays(14)<dif1){
        $('.err').html('Tanggal tidak boleh lebih dari 2 minggu!');
        $(this).val(`${dif2.getFullYear()}-${('0'+(dif2.getMonth() + 1)).slice(-2)}-${('0'+dif2.getDate()).slice(-2)}`);
        $(this).attr('data-date', `${('0'+dif2.getDate()).slice(-2)}/${('0'+(dif2.getMonth() + 1)).slice(-2)}/${dif2.getFullYear()}`);

      }else{
        $('.err').empty();
        $.get(`/lapangan/${id}/${date}`,function(){
        }).done(function(data){
          $('.waktu').empty();
          if(data){
            var hour = new Date();
            hour = hour.getHours();
            var c = 0;
            $(data).each(function(i,el){
              if(el.status){
                if(dif1.getDate() == dif2.getDate() && el.jam>hour){

                  $('.waktu').append(`
                     <div class="jam">
                      <input name='jam[]' type="checkbox" id="jam_${i}" value="${el.jam}">
                      <label for="jam_${i}">${el.display}</label>
                    </div>
                    `);
                  c++;
                }else if(dif1.getDate()!=dif2.getDate()){
                  $('.waktu').append(`
                     <div class="jam">
                      <input name='jam[]' type="checkbox" id="jam_${i}" value="${el.jam}">
                      <label for="jam_${i}">${el.display}</label>
                    </div>
                    `);
                  c++;
                }
              }

            });

            if(c==0){
              $('.proses-book').attr('disabled',true);
              $('.waktu').append("<label class='red-color'>Tempat sudah tutup </label> ")
            }else{
              $('.proses-book').attr('disabled',false);

            }
          }
        });

      }
    });
  });

  /*function updateTextView(_obj){
  var num = getNumber(_obj.val());
    if(num==0){
      _obj.val('');
    }else{
      _obj.val(num.toLocaleString());
    }
  }
  function getNumber(_str){
    var arr = _str.split('');
    var out = new Array();
    for(var cnt=0;cnt<arr.length;cnt++){
      if(isNaN(arr[cnt])==false){
        out.push(arr[cnt]);
      }
    }
    return Number(out.join(''));
  }
  $(document).ready(function(){
    $('input[type=number]').on('keyup',function(){
      updateTextView($(this));
  });
});*/

</script>
@endsection