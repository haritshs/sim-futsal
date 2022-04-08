@extends('layouts.app')

@section('content')

<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title">Transaksi sewa periode {{ $data['start_date'] }} sampai {{ $data['end_date'] }} dan status ' {{ $data['tipe'] }} '</h3>
        </div>
        <div class="card-body">
            <table id="hitung" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Waktu Booking</th>
                        <th>Lapangan</th>
                        <th>No Telpon</th>
                        <th>Status</th>
                        <th>Total Biaya</th>
					</tr>
                </thead>
                <tbody>
                    @foreach($bookings as $row)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $row['name'] }}</td>
						<td>{{ $row['email'] }}</td>
						<td>{{ $row['created_at'] }}</td>
						<td>{{ $row['lapangan_id'] }} </td>
						<td>{{ $row['no_telpon'] }}</td>
						<td>{{ $row['status'] }}</td>
						<td>{{ $row['total_harga'] }}</td>
					</tr>
                    @endforeach
                </tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>Total : Rp.</b></td>
                        <td id="sum1"></td>
                    </tr>
            </table>
            <button onclick="window.print()">Cetak</button>
        </div>
    </div>
</section>
@endsection

@push('scripts')

<script>
    var sum1 = 0;
    $("#hitung tr").not(':first').not(':last').each(function() {
    sum1 +=  getnum($(this).find("td:eq(7)").text());

    function getnum(t){
        if(isNumeric(t)){
            return parseInt(t,10);
        }
        return 0;
        function isNumeric(n) {
            return !isNaN(parseFloat(n)) && isFinite(n);
        }
    }
    
    });
    var	number_string = sum1.toString(),
    sisa 	= number_string.length % 3,
	rupiah 	= number_string.substr(0, sisa),
	ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    $("#sum1").text(rupiah);
</script>
@endpush