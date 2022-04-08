@extends('layouts.app')

@section('content')
<div class="card card-secondary card-outline">
    <div class="card-header">
        <h3 class="card-title">Data Gaji Bulan</h3>
    </div>
    <div class="card-body">
        <table id="myTable" class="table table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Gaji Pokok</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kehadirans as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->nama }}</td>
                    <td>{{ $row->jabatan }}</td>
                    <td>{{ $b }}</td>
                    <td>{{ $t }}</td>
                    <td>Rp. {{ number_format($row->gaji_pokok) }}</td>
                    <td>
                        <a href="{{ route('penggajian.detail_filter',[$row->karyawan_id, $b, $t]) }}" class="btn btn-sm btn-default"><i class="fa fa-bars"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection