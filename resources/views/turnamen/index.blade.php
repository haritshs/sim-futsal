@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title"><a href="{{ route('turnamen.create') }}" class="btn btn-primary">Tambah Data</a> </h3>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Slot Tim</th>
                        <th>Total hadiah</th>
                        <th>Biaya Daftar</th>
                        <th>Tanggal Mulai</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($turni as $row)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $row['judul'] }}</td>
                        <td>{{ $row['slot_tim'] }}</td>
                        <td>{{ number_format($row['total_hadiah']) }}</td>
                        <td>{{ number_format($row['biaya_daftar']) }}</td>
                        <td>{{ $row['tanggal_mulai'] }}</td>
                        <td>
                            <a href="{{ route('turnamen.edit',  ['id' => $row["id"]]) }}" class="btn btn-sm btn-warning"><i class="fa fa-cog"></i></a>
                            <a data-id="{{ $row['id'] }}" class="btn btn-sm btn-danger delete-btn"><i class="fa fa-trash"></i></a>
                            <a href="{{ route('turnamen.show',[$row->id] )}}" class="btn btn-sm btn-default" title="Detail"><i class="fa fa-bars"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- <div class="card-body">
            <div class="turnamenBracket"></div>
            <form action="{{ route('turnamen.save_bracket') }}" method="post">
            {{ csrf_field() }}
                <button type="submit">simpan</button>
            </form>
        </div> -->
    </div>
</section>
@endsection

@push('scripts')

<script>
    
$(".delete-btn").click(function(){
let id = $(this).attr('data-id');
    if(confirm("Apa anda yakin akan menghapus? ")) {
        $.ajax({
            url : "{{url('/')}}/admin/turnamen/"+id,
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

// var minData = {
//     teams: [
//       ["Team 1", "Team 2"],
//       ["Team 3", null],
//       ["Team 4", null],
//       ["Team 5", null]
//     ],
//     results: [
//         [
//           [[1, 0], [null, null], [null, null], [null, null]],
//           [[null, null], [1, 4]],
//           [[null, null], [null, null]]
//         ]
//     ]
//   };
//   $(function() {
//     $('.turnamenBracket').bracket({
//       init: minData /* data to initialize the bracket with */ })
//   });

  var saveData = {
  teams: [
    ["Team 1", "Team 2"],
    ["Team 3", null],
    ["Team 4", null],
    ["Team 5", null]
  ],
  results: [
      [
        [[1, 0], [null, null], [null, null], [null, null]],
        [[null, null], [1, 4]],
        [[null, null], [null, null]]
      ]
  ]
};
 
/* Called whenever bracket is modified
 *
 * data:     changed bracket object in format given to init
 * userData: optional data given when bracket is created.
 */
function saveFn(data, userData) {
  var json = jQuery.toJSON(data)
  $('#saveOutput').text('POST '+userData+' '+json)
  /* You probably want to do something like this
  jQuery.ajax("rest/"+userData, {contentType: 'application/json',
                                dataType: 'json',
                                type: 'post',
                                data: json})
  */
}
 
$(function() {
    var container = $('.turnamenBracket')
    container.bracket({
      init: saveData,
      save: saveFn,
      userData: "{{ route('turnamen.save_bracket') }}"})
 
    /* You can also inquiry the current data */
    var data = container.bracket('data')
    $('#dataOutput').text(jQuery.toJSON(data))
  })
    
</script>
@endpush