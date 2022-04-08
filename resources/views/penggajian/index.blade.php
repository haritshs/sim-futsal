@extends('layouts.app')

@section('content')
@if(!isset($_GET['filter']))
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-default">
      <form action="{{ route('gaji.filter') }}" method="get" >
        <div class="card-header">
            <h3 class="card-title">Filter Pencarian</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
        </div>
          <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Bulan</label>
                  <select name="bulan" class="form-control select2bs4" style="width: 100%;">
                    <option value="01" selected="selected">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tahun</label>
                    <input type="number" class="form-control" id="" name="tahun" placeholder="">
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Cari</button>
          </div>
      </form>
    </div>
@else
include('filter')
@endif
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title">Data Gaji Bulan {{ $tanggal->format('F') }}</h3>
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
                      <td>{{ $row->karyawan['nama'] }}</td>
                      <td>{{ $row->karyawan->jabatan['jabatan'] }}</td>
                      <td>{{ $tanggal->format('F') }}</td>
                      <td>{{ $tanggal->format('Y') }}</td>
                      <td>Rp. {{ number_format($row->karyawan->jabatan['gaji_pokok']) }}</td>
                      <td>
                          <a href="{{ route('penggajian.show',[$row->karyawan_id] )}}" class="btn btn-sm btn-default"><i class="fa fa-bars"></i></a>
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
    
/*$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })*/
</script>
@endpush
