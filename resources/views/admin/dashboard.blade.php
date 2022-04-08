@extends('layouts.app')
@section('chart')
    <script src="{{asset('main/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $total }}</h3>

                <p>Booking Total</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $bulan_ini }}<sup style="font-size: 20px"></sup></h3>

                <p>Booking Bulan Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>Rp. {{ number_format($pemasukan) }}</h3>

                <p>Pemasukan Bulan Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-calculator"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>Rp. {{ number_format($pengeluaran) }}</h3>

                <p>Pengeluaran Bulan Ini</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="card card-secondary card-outline">
            <!-- /.box-header -->
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</section>
@endsection


@section('script')
<script>
    var d = new Date();
    var n = d.getFullYear();
    var ctx = document.getElementById("myChart").getContext("2d");
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
            datasets: [{
                label: "Pemasukan",
                backgroundColor: 'rgb(0, 166, 90)',
                borderColor: 'rgb(0, 166, 90)',
                fill: false,
                data: [
                    @foreach($masuk as $mas)
                        {{ ($mas != 0) ? $mas : 'null' }},
                    @endforeach
                ]
            },
            {
                label: "Pengeluaran",
                backgroundColor: 'rgb(221, 75, 57)',
                borderColor: 'rgb(221, 75, 57)',
                fill: false,
                data: [
                    @foreach($keluar as $kel)
                        {{ ($kel != 0) ? $kel : 'null' }},
                    @endforeach
                ]
            }
            ]
        },

        // Configuration options go here
        options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Grafik Pemasukan dan Pengeluaran ' + n
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return "Rp" + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                                return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
                            });
                        }
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Bulan'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Jumlah'
                        },
                        ticks: {
                            beginAtZero: true,
                            callback: function(value, index, values) {
                            if(parseInt(value) >= 1000){
                                return 'Rp.' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                            } else {
                                return 'Rp.' + value;
                            }
                            }
                        }
                    }]
                }
        }
    });
</script>
@endsection
