@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <!-- <div class="card card-secondary card-outline">
        <div class="card-body">
            @foreach($potongans as $row)
            <form action="{{ route('pendapatan.update_potongan', [$row->id]) }}" method="POST" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <h4>Potongan Gaji</h4>
                        </div>
                        <div class="form-group">
                            <label>Alfa</label>
                            <input type="number" class="form-control" required name="p_alfa" value="{{ $row['p_alfa'] }}" >
                        </div>
                        
                        <div class="form-group">
                            <p>Izin</p>
                            <input type="number" class="form-control" required name="p_izin" value="{{ $row['p_izin'] }}">
                        </div>
                        <div class="form-group">
                            <p>Sakit</p>
                            <input type="number" class="form-control" required name="p_sakit" value="{{ $row['p_sakit'] }}">
                        </div>
                        <div class="form-group">
                            <p>Cuti</p>
                            <input type="number" class="form-control" required name="p_cuti" value="{{ $row['p_cuti'] }}">
                        </div>
                        <input type="submit">
                    </div>
                </div>
            </form>
            @endforeach
            <br>
            @foreach($pendapatans as $row)
            <form action="{{ route('pendapatan.update_pendapatan', [$row->id]) }}" method="POST" >
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <h4>Pendapatan Gaji</h4>
                        </div>
                        <div class="form-group">
                            <p>Lembur</p>
                            <input type="number" class="form-control" required name="uang_lembur" value="{{ $row['uang_lembur'] }}" >
                        </div>
                        <div class="form-group">
                            <p>Uang Makan</p>
                            <input type="number" class="form-control" required name="uang_makan" value="{{ $row['uang_makan'] }}">
                        </div>
                        <div class="form-group">
                            <p>Tunjangan</p>
                            <input type="number" class="form-control" required name="uang_tunjangan" value="{{ $row['uang_tunjangan'] }}">
                        </div>
                        <input type="submit">
                    </div>
                </div>  
            </form>
            @endforeach
        </div>
    </div> -->

    <div class="card card-default">
        <div class="card-header">
        <h3 class="card-title">Data Pendapatan & Potongan Gaji</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                @foreach($potongans as $row)
                <form action="{{ route('pendapatan.update_potongan', [$row->id]) }}" method="POST" >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <h4>Potongan Gaji</h4>
                            </div>
                            <div class="form-group">
                                <label>Alfa</label>
                                <input type="number" class="form-control" required name="p_alfa" value="{{ $row['p_alfa'] }}" >
                            </div>
                            
                            <div class="form-group">
                                <label>Izin</label>
                                <input type="number" class="form-control" required name="p_izin" value="{{ $row['p_izin'] }}">
                            </div>
                            <div class="form-group">
                                <label>Sakit</label>
                                <input type="number" class="form-control" required name="p_sakit" value="{{ $row['p_sakit'] }}">
                            </div>
                            <!-- <div class="form-group">
                                <label>Cuti</label>
                                <input type="number" class="form-control" required name="p_cuti" value="{{ $row['p_cuti'] }}">
                            </div> -->
                            <input type="submit">
                        </div>
                    </div>
                </form>
                @endforeach
                </div>
                <!-- /.form-group -->
                <div class="form-group">

                </div>
                <!-- /.form-group -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="form-group">
                @foreach($pendapatans as $row)
                <form action="{{ route('pendapatan.update_pendapatan', [$row->id]) }}" method="POST" >
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-md-6">
                            <div>
                                <h4>Pendapatan Gaji</h4>
                            </div>
                            <div class="form-group">
                                <label>Lembur</label>
                                <input type="number" class="form-control" required name="uang_lembur" value="{{ $row['uang_lembur'] }}" >
                            </div>
                            <div class="form-group">
                                <label>Uang Makan</label>
                                <input type="number" class="form-control" required name="uang_makan" value="{{ $row['uang_makan'] }}">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan</label>
                                <input type="number" class="form-control" required name="uang_tunjangan" value="{{ $row['uang_tunjangan'] }}">
                            </div>
                            <input type="submit">
                        </div>
                    </div>
                </form>
                @endforeach
                </div>
                
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.card-body -->
    </div>
    
</section>
@endsection

@push('scripts')

<script>
    
$(".delete-btn").click(function(){
let id = $(this).attr('data-id');
    if(confirm("Apa anda yakin akan menghapus? ")) {
        $.ajax({
            url : "{{url('/')}}/admin/jabatan/"+id,
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