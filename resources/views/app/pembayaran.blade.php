@extends('layouts.main')

@section('content')
<section id="pricing" class="pricing">
  <div class="container">
    @if($booking->status == 'baru')
      <div class="section-title" data-aos="zoom-out">
        <h2>Booking</h2>
        <p>Selesaikan Pembayaran Anda</p>
      </div>

      <div class="row">
        <div class="invoice-box">
          <table>
            <tr class="top">
              <td colspan="2">
                <table>
                  <tr>
                    <td class="title">
                      <h4>Order ID : {{ $booking['id'] }}</h4>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr class="information">
              <td colspan="2">
                <table>
                  <tr>
                    <td>
                      Nama Pelanggan<br />
                      <b>{{ $booking->user['name'] }}</b>
                      <br>
                      Tanggal Order
                      <br>
                      <b>{{ $booking['created_at']}}</b>
                    </td>

                    <td>
                      Status Pembayaran<br />
                      <b>{{ $booking['status']}}</b>
                      <br>
                      Batas Waktu Pembayaran<br />
                      <b>{{ $booking['batas_waktu'] }}</b>
                      <div class="timer"></div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr class="heading">
              <td>Metode Pembayaran</td>
              
              <td></td>
              
            </tr>

            <tr class="details">
              <td>{{ $booking['metode_bayar']}}</td>
            </tr>

            <tr class="heading">
              <td>Kode Voucher</td>

              <td></td>
            </tr>

            <tr class="item">
              @if( session()->has('vc') )
              <td>({{ session()->get('vc')['nama'] }}) : {{ number_format(session()->get('vc')['diskon']) }}</td>
              @else

              @forelse($vouchers as $vo)
              <td>gunakan kode voucher <b>{{ $vo->kode }}</b></td>
              @empty
              <td>tidak ada voucher</td>
              @endforelse
              
              @endif
              @if( !session()->has('vc') )
              <td>
                <form action="{{ route('add_voucher', ['id' => $booking["id"]]) }}" method="get">
                  {{ csrf_field() }}
                  <div>
                    <input type="text" name="input_voucher" id="input_voucher" placeholder="masukkan kode voucher">
                    <button type="submit">Apply</button>
                  </div>
                </form>
              </td>
              @endif
              @if( session()->has('vc') )
              <td>
                <form action="{{ route('booking.remove_voucher') }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('delete') }}
                  <button type="submit" style="font-size:12px">Remove</button>
                </form>
              </td>
              @endif
            </tr>

            <tr class="heading">
              <td>Item</td>

              <td>Harga</td>
            </tr>

            <tr class="item">
              <td>Harga Sewa</td>

              <td>Rp. {{ number_format($booking['total_harga']) }}</td>
            </tr>

            <tr class="item">
              <td>Diskon</td>
              
              @if( session()->has('vc') )
                <td>Rp. {{ number_format(session()->get('vc')['diskon']) }}</td>
              @else
                <td>Rp. 0</td>
              @endif
              
            </tr>

            <tr class="total">
              <td></td>
              @if( session()->has('vc') )
              <td><b>Total: Rp. {{ number_format(($booking->total_harga)-(session()->get('vc')['diskon'])) }}</td>
              @else
              <td><b>Total: Rp. {{ number_format($booking['total_harga']) }}</td>
              @endif
            </tr>
          </table>
          <br>
          @if($booking['status'] == 'baru')
          <button id="pay-button" type="submit"class="proses-book button w-100">Proses Ke Pembayaran</button>
          @endif
        </div>
        
        <!-- <div class="">
          <div class="box" data-aos="zoom-in">
            <h3>Order Id</h3>
            <h4>{{ $booking->id }}</h4>
            <br>
            <h3>Total Biaya</h3>
            @if (!session()->has('vc'))
            <h4>Rp. {{ number_format($booking->total_harga,2) }}</h4>
            @endif
            @if (session()->has('vc'))
            <h4>Rp. {{ number_format(($booking->total_harga)-(session()->get('vc')['diskon']),2) }}</h4>
            @endif
            <ul>
              <p>Tekan Tombol Bayar, & Pilih Metode Pembayaran</p>
            </ul>
            <button id="pay-button" type="submit">Bayar</button>
          </div>
        </div> -->
      </div>

      <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-MrWjMFcLqAV1zXHp"></script>
      <script type="text/javascript">

        document.getElementById('pay-button').onclick = function(){
          var resultType = document.getElementById('result-type');
          var resultData = document.getElementById('result-data');
          function changeResult(type,data){
            $("#result-type").val(type);
            $("#result-data").val(JSON.stringify(data));
            //resultType.innerHTML = type;
            //resultData.innerHTML = JSON.stringify(data);
          }
          // SnapToken acquired from previous step
          snap.pay('<?=$snapToken?>', {
            onSuccess: function(result){
              changeResult('success', result);
              console.log(result.status_message);
              console.log(result);
              $("#payment-form").submit();
            },
            onPending: function(result){
              changeResult('pending', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            },
            onError: function(result){
              changeResult('error', result);
              console.log(result.status_message);
              $("#payment-form").submit();
            }
          });
        };
      </script>
    @else
      <div class="section-title" data-aos="zoom-out">
        <h2>Booking</h2>
        <p>Detail Booking</p>
      </div>

      <div class="row">
        <div class="invoice-box">
          <table>
            <tr class="top">
              <td colspan="2">
                <table>
                  <tr>
                    <td class="title">
                      <h4>Order ID : {{ $booking['id'] }}</h4>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr class="information">
              <td colspan="2">
                <table>
                  <tr>
                    <td>
                      Nama Pelanggan<br />
                      <b>{{ $booking->user['name'] }}</b>
                      <br>
                      Tanggal Order
                      <br>
                      <b>{{ $booking['created_at']}}</b>
                    </td>

                    <td>
                      Status Pembayaran<br />
                      @if(!$booking)
                        @if($transaction_status == 'settlement')
                        <b>Sudah Dibayar</b>
                        @endif
                        @if($transaction_status == 'expire')
                        <b>Gagal</b>
                        @endif
                        @if($transaction_status == 'pending')
                        <b>Proses</b>
                        @endif
                        <br>
                        Batas Waktu Pembayaran<br />
                        <b>{{ $deadline }}</b>
                      @else
                      <b>{{ $booking['status'] }}</b>
                      <br>
                        Batas Waktu Pembayaran<br />
                        <b>{{ $booking['batas_waktu'] }}</b>
                      @endif  
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr class="heading">
              <td>Metode Pembayaran</td>
              <td></td>
            </tr>

            <tr class="details">
              @if($booking->status == 'batal')
              <td>Tidak ada</td>
              @else
              <td>{{$payment_type}}</td>
              
              <td>
                @if($vn == false)
                Transaction ID
                <b>{{$transaction_id}}</b>
                @else
                No Virtual Akun
                <b>{{ $va_numbers }} ({{ $bank }})</b>
                @endif
              </td>
              @endif
              
            
            </tr>

            <tr class="heading">
              <td>Item</td>

              <td>Harga</td>
            </tr>

            <tr class="item">
              <td>Harga Sewa</td>

              <td>{{ number_format($booking['total_harga']), 2}}</td>
            </tr>

            <tr class="item">
              <td>Diskon</td>

              <td>0</td>
            </tr>

            <tr class="total">
            @if(!$booking)
              <td></td>

              <td><b>Total: Rp. {{ number_format($gross_amount), 2}}</td>
            @else
              <td></td>
              <td><b>Total: Rp. {{ number_format($booking['total_harga']), 2}}</td>
            @endif
            </tr>
          </table>
          <br>
          <p>* Tunjukkan bukti reservasi lapangan pada pihak operator saat di lokasi</p>
        </div>

        
      </div>
    @endif
  </div>

  <form id="payment-form" method="get" action="">
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <input type="hidden" name="result_data" id="result-data" value=""></div>
  </form>
</section>
<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->

@endsection

@section('script')
<script type="text/javascript">

  @php
    $duetime = new DateTime($booking->created_at);
    // if($booking->metode_bayar == 'bank_transfer')
    // {
    //   $duetime->modify('+10 minutes');
    // }else{
    //   $duetime->modify('+30 minutes');
    // }
    $duetime->modify('+60 minutes');
    $duetimestr = date_format($duetime, 'Y-m-d H:i:s');
  @endphp
  $(function(){

    var countDownDate = new Date("{{$duetimestr}}").getTime();

    x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"

        $('.timer').html(minutes + " Menit " + seconds + " Detik ");

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
             $('.timer').html('EXPIRED');
        }
    }, 1000);
  });

</script>
@endsection