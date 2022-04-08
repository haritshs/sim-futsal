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
                        <th>Nama Tim</th>
                        <th>User</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftar as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->tim->nama_team }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>{{ $row->status }}</td>
                        <td>
                            <a href="" class="btn btn-sm btn-warning"><i class="fa fa-cog"></i></a>
                            <a data-id="" class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></a>
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
            url : "{{url('/')}}/admin/turnamen/"+id,
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