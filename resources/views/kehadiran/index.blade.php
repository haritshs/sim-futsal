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
                        <th>Nama Karyawan</th>
                        <th>Hadir</th>
                        <th>Alfa</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Cuti</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kehadirans as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->h }}</td>
                        <td>{{ $row->a }}</td>
                        <td>{{ $row->i }}</td>
                        <td>{{ $row->s }}</td>
                        <td>{{ $row->c }}</td>
                        <td>
                            <a href="{{ route('kehadiran.absen',[$row->karyawan_id] )}}" class="btn btn-sm btn-default"><i class="fa fa-plus"></i></a>
                            <a href="{{ route('kehadiran.show',[$row->karyawan_id] )}}" class="btn btn-sm btn-default"><i class="fa fa-bars"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
