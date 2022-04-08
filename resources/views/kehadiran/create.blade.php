@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        
        <div class="card-body">
            <form action="{{ route('kehadiran.simpan_absen') }}" method="post">
                {{ csrf_field() }}
                <table id="" class="table table-sm">
                    <thead>
                        <tr>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Tanggal Masuk</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            @foreach($karyawans as $row)
                            <td>
                                {{ $row->nama }}
                                <input type="hidden" name="karyawan_id" value="{{ $row['id'] }}">
                            </td>
                            <td>
                                {{ $row->jabatan->jabatan }}
                            </td>
                            <td>{{ $row->shift->jam_masuk }}</td>
                            <input type="hidden" name="shift_masuk" value="{{ $row->shift->jam_masuk }}">
                            <td>{{ $row->shift->jam_keluar }}</td>
                            @endforeach
                            <td>
                                <input name="tanggal" type="date" data-date-format="DD/MM/YYYY" class="date-picker" value="{{ date("Y-m-d") }}">
                            </td>
                            
                            <td>
                                <select name="keterangan" id="select" class="form-control">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Alpha">Alpha</option>
                                    <option value="Alpha">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Cuti">Cuti</option>
                                </select>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
                
                <td>
                    <button type="submit" name="btnIn" value="masuk" {{ $info['btnIn'] }}>Absen Masuk</button>
                </td>
                <td>
                    <button type="submit" name="btnOut" value="keluar" {{ $info['btnOut'] }}>Absen Keluar</button>
                </td>
            </form>
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