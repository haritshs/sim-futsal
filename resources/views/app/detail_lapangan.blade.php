@extends('layouts.main')

@section('content')
<div id="booking" class="overlay-wrap {{$errors->any()?' show':''}}">
  <div class="overlay"></div>
  <div class="form-panel ">
    @guest
    <div class="text-center">
      <h3>HARAP LOGIN TERLEBIH DAHULU</h3>
      <a href="{{ url('/') }}" class="button">HOME</a>
    </div>
    @else
      <h3>BOOKING LAPANGAN</h3>
      
      <br>
      <div class="form-wrap">
        <form method="POST" action="{{ url('booking') }}">
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
          <label class="text-left">Tanggal Main</label>
          <input id="main-date" name="tanggal_main" type="date" data-date="" data-date-format="DD/MM/YYYY" class="date-picker" value="{{ date("Y-m-d") }}">
          <br>
          <label class="text-left">Jam Main</label>
          <div class="waktu">
            @php
              $i=0;
            @endphp
            @foreach ($jadwal as $row)
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
          <br>
         
          <input type="hidden" name="lapangan_id" value="{{$id}}">
          <button  type="submit" class="proses-book button w-100">PROSES BOOKING</button>
        </form>
      </div>
    @endguest
  </div>
</div>

<div id="sparing" class="overlay-wrap {{$errors->any()?' show':''}}">
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
        <form method="POST" action="{{ url('daftar_sparing') }}">
        {{ csrf_field() }}
          @php
            $hour2 = \Carbon\Carbon::now('Asia/Jakarta')->hour;
          @endphp
          @if($errors->any())
            @foreach($errors->all() as $error)
              <p class="red-color err">{{ $error }}</p>
            @endforeach
          @else
            <label class="red-color err"></label>
          @endif
          @foreach($tims as $t)
            <label for="">Pilih Tim Anda</label>
            <select name="tim_id" id="select" class="form-control" placeholder="Pilih Tim Anda">
              <option value="{{ $t['id'] }}">{{ $t['nama_team'] }}</option>
            </select>
            <label for="">Hadiah Bagi Pemenang (boleh kosong)</label>
            <input type="text" id="total_hadiah" class="number" name="total_hadiah" placeholder="Rp.">
          @endforeach
          
          <!-- tes jv -->
          <label class="text-left">Tanggal Main</label>
          <input id="main-date-sparing" name="tanggal_main" type="date" data-date="" data-date-format="DD/MM/YYYY" class="date-picker" value="{{ date("Y-m-d") }}">
          <br>
          <label class="text-left">Jam Main</label>
          <div class="waktu-sparing">
            @php
              $j=0;
            @endphp
            @foreach ($jadwal as $row)
              @if($row->status)
                @if($hour < $row->jam)
                  <div class="jam-sparing">
                    <input type="checkbox" id="jam2_{{$j}}" name='jam2[]' value="{{$row->jam}}">
                    <label for="jam2_{{$j}}">{{$row->display}}</label>
                  </div>
                  @php
                    $j++;
                  @endphp
                @endif
              @endif

            @endforeach

            @if($j==0)
              <label class="red-color">Tempat sudah tutup</label>
            @endif

          </div>
          <!-- tes jv -->
          
          <br>

          <input type="hidden" name="lapangan_id" value="{{$id}}">
          <button {{$i==0?'disabled':''}} type="submit" class="proses-sparing button w-100">PROSES SPARING</button>
        </form>
      </div>
    @endguest
  </div>
</div>

<div style="position: relative;min-height: 600px; overflow: hidden;margin-bottom: 50px;">
  <div style="margin-top: 50px;" class="container">
    <div class="section-title" data-aos="zoom-out">
      <h2>Lapangan</h2>
      <p>Detail Lapangan</p>
    </div>
    <div class="detail-wrapper">
      <div class="first"><img src="{{ asset('template/images/'.$lapangans->foto) }}" style="width:700px;height:600px;"> </div>
      <div class="second">
        <h3> <b>{{ $lapangans->nama }}</b></h3>
        <hr>
        <h6>Deskripsi</h6>
        <p> <b>{{ $lapangans->deskripsi }}</b></p>
        <br>
        <h6>Jenis Lapangan</h6>
        <p> <b>{{ $lapangans->jenis }}</b></p>
        <br>
        <h6>Harga Sewa</h6>
        <h4 class="red-color">Rp. {{ number_format($lapangans->harga_sewa,2) }}</h4>
        <br>
          
        <button type="submit" data-modal='#booking' class="showModal">BOOKING LAPANGAN</button>
        <hr>
        @if($tims->isNotEmpty())
        <button type="submit" data-modal='#sparing' class="showModal">DAFTAR SPARING</button>
        @endif
      </div>
    </div>
    <br>
    <h2>Jadwal Lapangan</h2>
    <hr>
    <div class="row">
      <div class="col-md-3">
        <input id="filter-date" type="date" data-date="" data-date-format="DD/MM/YYYY" class="date-picker" value="{{ date("Y-m-d") }}">
      </div>

      <div class="col-md-8">
        <button class="btn-lihat" type="submit">Lihat</button>
      </div>
    </div>
    <br>
    <br>
    <div class="custom-scroll" style="width: 100%;overflow-x: scroll; padding: 10px 0px;">
      <table class="table-wrap">
        <thead>
          <tr>
            <th class="red-color">JAM</th>
            @for ($i=7; $i <23 ; $i++)
            <th class="red-color">{{$i}} - {{$i+1}}</th>
            @endfor
          </tr>
          <tr class="tersedia">
            <th>KETERSEDIAAN</th>

            @foreach ($jadwal as $row)
              @if($row->status == false)
              <th class="red-color">BOOKED</th>
              @else
              <th>KOSONG</th>
              @endif

            @endforeach
          </tr>
        </thead>
      </table>
    </div>

  </div>
</div>

@endsection


@section('script')
<script type="text/javascript">
  $(function(){
    $('#main-date').change(function(){
      var id = {{$id}};
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

    // $('#main-date-sparing').change(function(){
    //   var id = {{$id}};
    //   var date = $(this).val();
    //   var dif1 = new Date(date);
    //   var dif2 = new Date();
    //   dif1.setHours(0,0,0,0);
    //   dif2.setHours(0,0,0,0);
    //   if(dif1<dif2){
    //     $('.err').html('Tanggal tidak boleh kurang dari hari ini!');

    //     $(this).val(`${dif2.getFullYear()}-${('0'+(dif2.getMonth() + 1)).slice(-2)}-${('0'+dif2.getDate()).slice(-2)}`);
    //     $(this).attr('data-date', `${('0'+dif2.getDate()).slice(-2)}/${('0'+(dif2.getMonth() + 1)).slice(-2)}/${dif2.getFullYear()}`);
    //   }else if(dif2.addDays(14)<dif1){
    //     $('.err').html('Tanggal tidak boleh lebih dari 2 minggu!');
    //     $(this).val(`${dif2.getFullYear()}-${('0'+(dif2.getMonth() + 1)).slice(-2)}-${('0'+dif2.getDate()).slice(-2)}`);
    //     $(this).attr('data-date', `${('0'+dif2.getDate()).slice(-2)}/${('0'+(dif2.getMonth() + 1)).slice(-2)}/${dif2.getFullYear()}`);

    //   }else{
    //     $('.err').empty();
    //     $.get(`/lapangan/${id}/${date}`,function(){
    //     }).done(function(data){
    //       $('.waktu-sparing').empty();
    //       if(data){
    //         var hour = new Date();
    //         hour = hour.getHours();
    //         var c = 0;
    //         $(data).each(function(j,el){
    //           if(el.status){
    //             if(dif1.getDate() == dif2.getDate() && el.jam>hour){

    //               $('.waktu-sparing').append(`
    //                  <div class="jam-sparing">
    //                   <input name='jam2[]' type="checkbox" id="jam2_${j}" value="${el.jam}">
    //                   <label for="jam2_${j}">${el.display}</label>
    //                 </div>
    //                 `);
    //               c++;
    //             }else if(dif1.getDate()!=dif2.getDate()){
    //               $('.waktu-sparing').append(`
    //                  <div class="jam-sparing">
    //                   <input name='jam2[]' type="checkbox" id="jam2_${j}" value="${el.jam}">
    //                   <label for="jam2_${j}">${el.display}</label>
    //                 </div>
    //                 `);
    //               c++;
    //             }
    //           }

    //         });

    //         if(c==0){
    //           $('.proses-sparing').attr('disabled',true);
    //           $('.waktu-sparing').append("<label class='red-color'>Tempat sudah tutup </label> ")
    //         }else{
    //           $('.proses-sparing').attr('disabled',false);

    //         }
    //       }
    //     });

    //   }
    // });
    
  
    $('.btn-lihat').click(function(){
      $(this).html('loading...');
      var id = {{$id}};
      var date = $('#filter-date').val();
      $.get(`/lapangan/${id}/${date}`,function(){
        $('.btn-lihat').html('lihat');

      }).done(function(data){
        $('.tersedia').empty();
        $('.tersedia').append('<th>KETERSEDIAAN</th>');
        if(data){

          $(data).each(function(i,el){
            if(el.status){
              $('.tersedia').append('<th>KOSONG</th>');

            }else{
              $('.tersedia').append('<th class="red-color">BOOKED</th>');

            }

          });
        }
      });
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
  //document.getElementById('total_hadiah').value = '0';
  /*$('input.number').keyup(function(event) {
      // skip for arrow keys
      if(event.which >= 37 && event.which <= 40) return;

      // format number
      $(this).val(function(index, value) {
      return value
      .replace(/\D/g, "")
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
      ;
      });
  });*/
</script>

<script type="text/javascript">
  $(function(){
    $('#main-date-sparing').change(function(){
      var id2 = {{$id}};
      var date2 = $(this).val();
      var dif12 = new Date(date2);
      var dif22 = new Date();
      dif12.setHours(0,0,0,0);
      dif22.setHours(0,0,0,0);
      if(dif12<dif22){
        $('.err').html('Tanggal tidak boleh kurang dari hari ini!');

        $(this).val(`${dif22.getFullYear()}-${('0'+(dif22.getMonth() + 1)).slice(-2)}-${('0'+dif22.getDate()).slice(-2)}`);
        $(this).attr('data-date-sparing', `${('0'+dif22.getDate()).slice(-2)}/${('0'+(dif22.getMonth() + 1)).slice(-2)}/${dif22.getFullYear()}`);
      }else if(dif22.addDays(14)<dif12){
        $('.err').html('Tanggal tidak boleh lebih dari 2 minggu!');
        $(this).val(`${dif22.getFullYear()}-${('0'+(dif22.getMonth() + 1)).slice(-2)}-${('0'+dif22.getDate()).slice(-2)}`);
        $(this).attr('data-date-sparing', `${('0'+dif22.getDate()).slice(-2)}/${('0'+(dif22.getMonth() + 1)).slice(-2)}/${dif22.getFullYear()}`);

      }else{
        $('.err').empty();
        $.get(`/lapangan/${id2}/${date2}`,function(){
        }).done(function(data2){
          $('.waktu-sparing').empty();
          if(data2){
            var hour2 = new Date();
            hour2 = hour2.getHours();
            var c1 = 0;
            $(data2).each(function(x,el){
              if(el.status){
                if(dif12.getDate() == dif22.getDate() && el.jam>hour2){
                  $('.waktu-sparing').append(`
                     <div class="jam-sparing">
                      <input name='jam2[]' type="checkbox" id="jam2_${x}" value="${el.jam}">
                      <label for="jam2_${x}">${el.display}</label>
                    </div>
                    `);
                  c1++;
                }else if(dif12.getDate()!=dif22.getDate()){
                  $('.waktu-sparing').append(`
                     <div class="jam-sparing">
                      <input name='jam2[]' type="checkbox" id="jam2_${x}" value="${el.jam}">
                      <label for="jam2_${x}">${el.display}</label>
                    </div>
                    `);
                  c1++;
                }
              }

            });

            if(c1==0){
              $('.proses-sparing').attr('disabled',true);
              $('.waktu-sparing').append("<label class='red-color'>Tempat sudah tutup </label> ")
            }else{
              $('.proses-sparing').attr('disabled',false);

            }
          }
        });
      }
    });
  });
</script>

@endsection
