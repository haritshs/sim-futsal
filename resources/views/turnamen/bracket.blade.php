@extends('layouts.app')

@section('content')
<!-- DATA TABLE -->
<section class="content">
    <div class="card card-secondary card-outline">
        <div class="card-header">
            <h3 class="card-title"><a href="" class="btn btn-primary">Bracket</a> </h3>
        </div>
        <div class="card-body">
            <div class="turnamenBracket"></div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

<script type="text/javascript">
  var minData = {
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
  $(function() {
    $('.turnamenBracket').bracket({
      init: minData /* data to initialize the bracket with */ })
  });
</script>
@endpush