@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        
        <div class="card-header">
            @foreach($karyawans as $kar)
            <h5>Nama : {{ $kar->nama }}</h5>
            <h5>Jabatan : {{ $kar->jabatan->jabatan }}</h5>
            @endforeach
        </div>
        <div class="card-body">
            <table id="" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Keterangan</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($kehadirans as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->tanggal->format('D, d M Y') }}</td>
                        <td>{{ $row->jam_masuk }}</td>
                        <td>{{ $row->jam_keluar }}</td>
                        <td>{{ $row->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
