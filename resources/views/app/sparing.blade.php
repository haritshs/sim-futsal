@extends('layouts.main')
@section('content')


<section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title" data-aos="zoom-out">
          <h2>Info</h2>
          <p>Dicari Lawan Sparing</p>
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

          <div class="col-md-10">

            @if($sparings->isEmpty())
            <h5>DATA TIDAK ADA</h5>

            @else
            <ul class="riwayat">
              @foreach($sparings as $row)
                <li>
                  <div class="row" >
                    <div class="col-md-4">
                      <img src="{{ asset('template/images/tim/'.$row->tim->logo) }}" style="width:100px;height:100px;">
                      <p><b>{{ $row->tim->nama_team }}</b></p>
                      <h2>vs</h2>
                      @foreach($row->lawan as $row2)
                      <img src="{{ asset('template/images/tim/'.$row2->tim->logo) }}" style="width:100px;height:100px;">
                      <p><b>{{ $row2->tim->nama_team }}</b></p>
                      @endforeach
                    </div>
                    
                    <div class="col-md-3">
                      <h3>INFO</h3>
                      <h5>NO TELEPON</h5>
                      <p> <b>{{ $row->user->no_telpon }}</b> </p>
                      <h5>HADIAH:</h5>
                      <p><b>Rp. {{ number_format($row->total_hadiah) }}</b></p>
                      <h5>TANGGAL MAIN:</h5>
                      <p><b>{{ $row->tgl_main }}</b></p>
                      
                      @foreach($row->booking->detail as $det)
                      <h5>LAPANGAN :</h5>
                      <p><b>{{ $det['lapangan_id'] }}</b></p>
                      <h5>JAM MAIN :</h5>
                      <p><b>{{ $det['jam_awal'] }} - {{ $det['jam_akhir'] }}</b></p>
                      @endforeach
                    </div>
                    
                    <div class="col-md-3">
                      <h3>STATUS</h3>
                      <p class="statusUpdate {{$row->status}}">
                        @if($row->status == 'tunggu')
                          Menunggu Lawan
                        @endif
                        @if($row->status == 'terima')
                          Sudah Ada Lawan
                        @endif
                        @if($row->status == 'lunas')
                          Sudah Ada Lawan
                        @endif
                      </p>
                    </div>
                    <div class="col-md-2">
                      <h3 class="text-center">AKSI</h3>
                      @if($row->status == 'tunggu' && $row->user_id != Auth::user()->id && $row->total_hadiah == 0)
                        <form action="{{ route('sparing.lawan-sparing', ['id' => $row["id"]]) }}" method="post">
                        {{ csrf_field() }}
                          <button type="submit">LAWAN</button>
                        </form>
                      @endif
                      @if($row->status == 'tunggu' && $row->user_id != Auth::user()->id && $row->total_hadiah != 0 )
                      <a href="{{ url('/sparing/pembayaran/'.$row->id) }}" class="detailButton"  > BAYAR & LAWAN</a>
                      @endif
                      @if($row->status == 'lunas' && $row->user_id != Auth::user()->id)
                      <a href="{{ url('/update_status_sparing/'.$row->id) }}" class="detailButton" >DETAIL</a>
                      
                      @endif
                      @if($row->user_id == Auth::user()->id)
                      <a href="{{ url('/booking/pembayaran/'.$row->booking_id) }}" class="detailButton" >DETAIL Booking</a>
                      <br>
                      <br>
                      <a href="{{ url('/sparing/pemenang/'.$row->id) }}" class="detailButton" >PEMENANG</a>
                      @endif
                      <br>
                      
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
            @endif
          </div>

      </div>
    </section>
@endsection

@section('script')
<script type="text/javascript">

$(function(){
    var i=0;
    t = $('#myTable').DataTable({
        ajax:{
        type: 'GET',
        url: '{{ url('/api/pemenang') }}'
        },
        columns:[
        { data : "id" , render: function(data,row){
            i++;
            return i;
        }},
        { data : "user.email"},
        { data : "detail.0.lapangan.nama"},
        { data : "id",render(data,t,row){
            var btn = `<button class="sid_${data} showDetail btn btn-sm btn-default" data-json='${JSON.stringify(row)}'  data-toggle="modal" data-target="#form-detail"  title="Detail"><i class="fa fa-bars"></i></button>`;
        }},
        ]
    });

    $(document).on('click','.showDetail', function(){
        var json = $(this).data('json');
        console.log(json);
        $('.t-tim_id').html(json.user.tim_id);
        $('.t-pesan').html(json.user.pesan);
        $('.t-hadiah_pemenang').html(json.hadiah_pemenang);
        $('.t-nama_pengirim').html(json.nama_pengirim);
        $('.t-bukti_transfer').html(`
            <img src='${json.bukti_transfer}' width='200'>
        `);
    });
})
</script>
  
@endsection