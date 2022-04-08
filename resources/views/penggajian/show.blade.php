@extends('layouts.app')

@section('content')
<!-- Content End -->
<section class="content">
  @foreach($gaji as $row)
  <div class="invoice p-3 mb-3">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h4>
            <i class="fas fa-globe"></i> Primavera Futsal.
          </h4>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          
            <br>
            <b>No Slip Gaji:</b> {{ $slip }}<br>
            <b>Nama Karyawan:</b> {{ $row->nama }}<br>
            <b>Jabatan:</b> {{ $row->jabatan }}
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
          
            <br>
            <b>Tanggal Cetak:</b> {{ $tanggal }}<br>
            <b>Bulan:</b> {{ $tanggal->format('F') }}<br>
            <b>Tahun:</b> {{ $tanggal->format('Y') }}
        </div>
        <!-- /.col -->
      </div>
      <br>
      <!-- /.row -->
      <!-- Table row -->
    <div class="row">
    <div class="col-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Rincian Pendapatan</h3>
        </div>
        <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>                  
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Rincian</th>
                  <th>Nominal</th>
                  
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1.</td>
                  <td>Gaji Pokok</td>
                  <td>
                  Rp {{ number_format($row->gaji_pokok, 0) }}
                  </td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Tunjangan</td>
                  <td>
                    Rp {{number_format($pendapatan->uang_tunjangan, 0)}}
                  </td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Uang Makan</td>
                  <td>
                    Rp {{number_format($pendapatan->uang_makan*$row->h, 0)}}
                  </td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Uang Lembur</td>
                  <td>
                    Rp {{number_format($pendapatan->uang_lembur, 0)}}
                  </td>
                </tr>
                <tr>
                  @if ($row->a==0 and $row->i==0 and $row->s==0 and $row->c==0)
                  <?php $insentif = $row->insentif; ?>
                  @else
                  <?php $insentif = 0; ?>
                  @endif
                  <td>5.</td>
                  <td>Insentif</td>
                  <td>
                    Rp {{ number_format($insentif) }}
                  </td>
                </tr>
                <tr>
                  <td>6.</td>
                  <td><b>Total Pendapatan</b></td>
                  <td>
                  <b> Rp {{number_format(($row->gaji_pokok + $pendapatan->uang_tunjangan + $pendapatan->uang_lembur + ($pendapatan->uang_makan*$row->h) + $insentif), 0)}} </b>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        <!-- /.card-body -->
        </div>
      </div>

      <div class="col-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Rincian Potongan</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Rincian</th>
                  <th>Nominal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1.</td>
                  <td>Alfa</td>
                  <td>
                    Rp {{ number_format($row->a*$potongan->p_alfa, 0) }}
                  </td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Izin</td>
                  <td>
                    Rp {{ number_format($row->i*$potongan->p_izin, 0) }}
                  </td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Sakit</td>
                  <td>
                    Rp {{ number_format($row->s*$potongan->p_sakit, 0) }}
                  </td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Cuti</td>
                  <td>
                  Rp {{ number_format($row->c*$potongan->p_cuti, 0) }}
                  </td>
                </tr>
                <tr>
                  <td>5.</td>
                  <td></td>
                  <td>

                  </td>
                </tr>
                <tr>
                  <td>6.</td>
                  <td><b>Total Potongan</b></td>
                  <td>
                  <b> Rp {{number_format(($row->a*$potongan->p_alfa)+($row->i*$potongan->p_izin)+($row->s*$potongan->p_sakit)+($row->c*$potongan->p_cuti) ,0)}} </b>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
    <div class="row">
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Total Gaji Yang Diterima</p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>
              Rp {{number_format
              (
              (
                ($row->gaji_pokok + $pendapatan->uang_tunjangan + $pendapatan->uang_lembur + ($pendapatan->uang_makan*$row->h) + $insentif
              ) 
              - 
              (
                ($row->a*$potongan->p_alfa)+($row->i*$potongan->p_izin)+($row->s*$potongan->p_sakit)+($row->c*$potongan->p_cuti)
              )
              ), 0)
            }}
              </td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div>
      <a href="{{ route('penggajian.cetakslip',['id'=>$row->karyawan_id]) }}">Cetak Slip</a>
    </div>
  </div>
  @endforeach
</section>
@endsection