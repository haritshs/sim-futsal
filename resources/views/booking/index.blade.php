@extends('layouts.app')

@section('content')
<div id="verif" tabindex="-1" role="dialog" style="" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <div class="text-success"><span class="modal-main-icon mdi mdi-check"></span></div>
          <h3>Apakah anda yakin memverifikasi booking ini?</h3>
          <p>Lapang akan resmi disewa oleh pengguna</p>
          <div class="xs-mt-50">
            <form method="POST">
            {{ csrf_field() }}
              <input type="hidden" name="_method" value="PUT">
              <button type="submit" class="btn btn-space btn-success">Proses</button>
              <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>
            </form>
          </div>
        </div>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<div id="batal-booking" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
            </div>
                <div class="modal-body">
                <div class="text-center">
                    <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
                    <h3>Perhatian!</h3>
                    <p>Apakah anda yakin akan membatalkan booking ini? berikan alasan agar pengguna tidak bingung</p>
                    <div class="xs-mt-50">
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                        <input class="form-control" type="text" name="pesan_batal" placeholder="Pesan cancel, cth: bukti transfer palsu" required>
                        </div>
                        <button type="submit" class="btn btn-space btn-danger">Proses</button>
                        <button type="button" data-dismiss="modal" class="btn btn-space btn-default">Cancel</button>

                    </form>
                    </div>
                </div>
                </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<!-- DATA TABLE -->
<section class="content">
<div class="card card-secondary card-outline">
    <div class="card-body">
    <table id="myTable" class="table table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Email</th>
                <th>Lapangan</th>
                <th>Total Harga</th>
                <th>Waktu Booking</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $row)
                @php
                    $lapangan = $row->detail->first()->lapangan;
                @endphp
            <tr>
                <td>1</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $lapangan->nama }}</td>
                <td>Rp. {{ number_format($row->total_harga,2) }}</td>
                <td>{{ $row->created_at }}</td>
                <td>
                    @if($row->status == 'baru' )
                        <span class="btn btn-xs btn-info">{{$row->status}}</span>
                    @elseif($row->status == 'batal')
                        <span class="btn btn-xs btn-danger">{{$row->status}}</span>
                    @elseif($row->status == 'diverifikasi')
                        <span class="btn btn-xs btn-success">{{$row->status}}</span>
                    @elseif($row->status == 'lunas')
                        <span class="btn btn-xs btn-warning">{{$row->status}}</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-sm btn-default" data-id="{{$row->id}}" type="button" data-toggle="modal" data-target="#form-detail" title="Detail"><i class="fa fa-bars"></i></a>
                  @if($row->status=='lunas')
                    <div class="btn-group">
                        <a class="btn btn-sm btn-info" type="button" title="Verifikasi" data-target="#verif" ><i class="fa fa-check"></i></a>
                        <a class="btn btn-sm btn-danger" type="button" title="Batal Booking" data-target="#batal-booking" ><i class="fa fa-times"></i></a>
                    </div>
                  @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</section>
@include('booking.form_detail')
@endsection


@section('script')
<script type="text/javascript">

$(function(){
    var i=0;
    t = $('#myTable').DataTable({
        ajax:{
        type: 'GET',
        url: '{{ url('/admin/api/booking') }}'
        },
        columns:[
        { data : "id" , render: function(data,row){
            i++;
            return i;
        }},
        { data : "user.email"},
        { data : "detail.0.lapangan.nama"},
        { data : "total_harga", render(data){
            var inp = (data/1000).toFixed(3);
            return `Rp. ${inp}`;
        }},
        { data : "created_at"},
        { data : "status", render(data){
            if(data == 'baru' )
            return `<span class="btn btn-xs btn-info">${data}</span>`;
            else if(data == 'batal')
            return `<span class="btn btn-xs btn-danger">${data}</span>`;
            else if(data == 'diverifikasi')
            return `<span class="btn btn-xs btn-success">${data}</span>`;
            else if(data == 'lunas')
            return `<span class="btn btn-xs btn-warning">${data}</span>`;

        }},
        { data : "id",render(data,t,row){
            var btn = `<button class="sid_${data} showDetail btn btn-sm btn-default" data-json='${JSON.stringify(row)}'  data-toggle="modal" data-target="#form-detail"  title="Detail"><i class="fa fa-bars"></i></button>`;
            if(row.status=='lunas')
            btn += `
            <button class="showVerif btn btn-sm btn-success" data-id="${data}" data-toggle="modal" data-target="#verif" title="Verifikasi"><i class="fa fa-check"></i></button>
            <button class="showCancel btn btn-sm btn-danger" data-id="${data}" data-toggle="modal" data-target="#cancel" title="Cancel Booking"><i class="fa fa-times"></i></button>

            `;
            return btn;
        }},
        ]
    });

    $(document).on('click','.showDetail', function(){
        var json = $(this).data('json');
        console.log(json);
        $('.t-id').html(json.id);
        $('.t-nama').html(json.user.name);
        $('.t-status').html(json.status);
        $('.t-lapangan').html(json.detail[0].lapangan.nama);
        $('.t-telpon').html(json.user.no_telpon);
        var waktu = `Tanggal : ${json.detail[0].tanggal_main} <br> Jam :`;
        json.detail.forEach(function(el,i){
        waktu += `(${el.jam_awal} - ${el.jam_akhir}) `;
        });
        $('.t-waktu').html(waktu);
        $('.t-created_at').html(json.created_at);
        $('.t-pesan_batal').html(json.pesan_batal);
        if(json.status=='lunas' || json.status=='diverifikasi'){
        }
    });


    $(document).on('click','.showVerif',function(){
        var id = $(this).data('id');
        $('#verif form').attr('action', `/admin/booking/${id}/verify`);
    });

    $(document).on('click','.showCancel',function(){
        var id = $(this).data('id');
        $('#batal-booking form').attr('action', `/admin/booking/${id}/batal_booking`);
    });
})
</script>
  
@endsection
