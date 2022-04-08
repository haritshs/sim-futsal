@extends('layouts.app')

@section('content')
@if(!isset($_GET['tipe']))
<div class="jumbotron">
    <div class="row">
        <div class="col-md-8"><b>Tanggal Booking</b></div>	
        <div class="col-md-4"><b>Order Status</b></div>
    </div>
    <hr>
    <form action="" method="get">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" name="start_date" placeholder="Start Date" id="datepicker">
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="end_date" placeholder="End Date" id="datepickers">
            </div>
            <div class="col-md-4">
                <select name="tipe" class="form-control">
                    <option value="all">All</option>
                    <option value="baru">Baru</option>
                    <option value="batal">Batal</option>
                    <option value="diverifikasi">Verified</option>
                    <option value="lunas">Lunas</option>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-secondary btn-block">CARI</button>
            </div>
        </div>
    </form>
</div>
@else
	include('show')
@endif

@endsection