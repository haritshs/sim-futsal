@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tim Sparing</th>
                        <th>Tanggal Main</th>
                        <th>Jam Main</th>
                        <th>Hadiah</th>
                        <th>Status</th>
                        <th>Pemenang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sparings as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->tim->nama_team }} <b>VS</b> @foreach($row->lawan as $row2) {{ $row2->tim->nama_team }} @endforeach</td>
                        <td>{{ $row['tgl_main'] }}</td>
                        <td>@foreach($row->booking->detail as $det) {{ $det['jam_awal'] }} - {{ $det['jam_akhir'] }} @endforeach</td>
                        <td>{{ number_format($row['total_hadiah']) }}</td>
                        <td>{{ $row['status'] }}</td>
                        <td>
                            <a href="{{ route('sparing.edit',  ['id' => $row["id"]]) }}" class="btn btn-sm btn-warning"><i class="fa fa-bars"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@include('sparing.form_pemenang')
@endsection
@push('scripts')

<script type="text/javascript">

    $(document).ready(function () {
        var table = $('#myTable').DataTable();

        table.on('click', 'edit', function() {
            $tr = $(this).closest('tr');
            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#tim_id').val(data[1]);
            $('#pesan').val(data[2]);
            $('#hadiah_pemenang').val(data[3]);
            $('#bukti_transfer').val(data[4]);
            $('#nama_pengirim').val(data[5]);
            $('#sparing_id').val(data[6]);

            $('#editForm').attr('action', '/admin/sparing/'+data[6]);
            $('#editModal').modal('show');
        });
    });
    
$(".delete-btn").click(function(){
let id = $(this).attr('data-id');
    if(confirm("Apa anda yakin akan menghapus? ")) {
        $.ajax({
            url : "{{url('/')}}/sparing/"+id,
            method : "POST",
            data : {
                _token : "{{csrf_token()}}",
                _method : "DELETE",
            }
        })
        .then(function(data){
            location.reload();
        });
    }
});

$('#form-pemenang').on('show', function(e) {
    var link     = e.relatedTarget(),
        modal    = $(this),
        id = link.data("id"),
        nama    = link.data("nama");

    modal.find("#idtim").val(id);
    modal.find("#namatim").val(nama);
});
    
</script>
@endpush