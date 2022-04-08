@extends('layouts.app')

@section('content')

<!-- DATA TABLE -->
<div class="table-data__tool">
    <div class="table-data__tool-right">
        
        <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
            <select class="js-select2" name="type">
                <option selected="selected">Export</option>
                <option value="">Option 1</option>
                <option value="">Option 2</option>
            </select>
            <div class="dropDownSelect2"></div>
        </div>
    </div>
</div>
<div class="table-responsive table-responsive-data2">
    <table class="table">
        <thead>
        <tr>
            <th>Nama</th>
            <td>: </td>
            <td></td>
        </tr>
        </thead>
        <tr>
            <th>No Telepon</th>
            <td>: </td>
            <td></td>
        </tr>
        <tr>
            <th>Waktu Booking </th>
            <td>: </td>
            <td></td>
        </tr>
        <tr>
            <th>Lapangan</th>
            <td> : </td>
            <td></td>
        </tr>
        <tr>
            <th>Waktu Main</th>
            <td> : </td>
            <td></td>
        </tr>
        <tr>
            <th>Status</th>
            <td> : </td>
            <td></td>
        </tr>
        <tr>
            <th>Nama Pengirim</th>
            <td> : </td>
            <td></td>
        </tr>
        <tr>
            <th>Bukti Transfer</th>
            <td> : </td>
            <td></td>
        </tr>
        
    </table>
</div>
@endsection