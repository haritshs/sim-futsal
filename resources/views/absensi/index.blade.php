@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title"><a href="{{ route('absensi.create') }}" class="btn btn-primary">Tambah Data</a> </h3>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Bulan</th>
                        <th>Hadir</th>
                        <th>Alfa</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Lembur</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row['karyawan_id'] }}</td>
                        <td>{{ $row['bulan'] }}</td>
                        <td>{{ $row['tahun'] }}</td>
                        <td>{{ $row['jml_hadir'] }}</td>
                        <td>{{ $row['jml_alfa'] }}</td>
                        <td>{{ $row['jml_izin'] }}</td>
                        <td>{{ $row['jml_sakit'] }}</td>
                        <td>{{ $row['jml_lembur'] }}</td>
                        <td>
                            <a href="{{ route('absensi.edit',  ['id' => $row["id"]]) }}" class="btn btn-sm btn-warning"><i class="fa fa-cog"></i></a>
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
            url : "{{url('/')}}/absensi/"+id,
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