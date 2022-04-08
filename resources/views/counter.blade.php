<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <link rel="stylesheet"  href="{{ asset('main/assets/css/jquery.bracket.min.css') }}" />
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
  </p>
  <div class="turnamenBracket"></div>
  
  <script src="{{ asset('main/js/jquery.min.js') }}"></script>
  <script src="{{ asset('main/js/jquery.bracket.min.js') }}"></script>
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
</body>

