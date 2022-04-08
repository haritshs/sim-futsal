@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title"><a href="{{ route('voucher.create') }}" class="btn btn-primary">Tambah Data</a> </h3>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tipe</th>
                        <th>Nominal</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vouchers as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row['kode'] }}</td>
                        <td>{{ $row['tipe'] }}</td>
                        <td>{{ number_format($row['nominal_diskon']) }}</td>
                        <td>
                            <a href="{{ route('voucher.edit',  ['id' => $row["id"]]) }}" class="btn btn-sm btn-warning"><i class="fa fa-cog"></i></a>
                            <a data-id="{{$row['id']}}" class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</section>
@endsection

@push('scripts')

<script>
    
$(".delete-btn").click(function(){
let id = $(this).attr('data-id');
    if(confirm("Apa anda yakin akan menghapus? ")) {
        $.ajax({
            url : "{{url('/')}}/admin/voucher/"+id,
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
    
</script>
@endpush