@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title"><a href="{{ route('tim.create') }}" class="btn btn-primary">Tambah Data</a> </h3>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tim</th>
                        <th>Kapten</th>
                        <th>Deskripsi</th>
                        <th>Domisili</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tims as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row['nama_team'] }}</td>
                        <td>{{ $row['nama_kapten'] }}</td>
                        <td>{{ $row['deskripsi'] }}</td>
                        <td>{{ $row['domisili'] }}</td>
                        <td>
                            <a href="{{ route('tim.edit',  ['id' => $row["id"]]) }}" class="btn btn-sm btn-warning"><i class="fa fa-cog"></i></a>
                            <a data-id="{{ $row['id'] }}" class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></a>
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
            url : "{{url('/')}}/admin/tim/"+id,
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
