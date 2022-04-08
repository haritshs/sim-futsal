@extends('layouts.main')

@section('content')
<section id="pricing" class="pricing">
  <div class="container">
    @if($sparings->status == 'tunggu')
      <div class="section-title" data-aos="zoom-out">
        <h2>Pricing</h2>
        <p>Selesaikan Pembayaran Anda</p>
      </div>

      <div class="row">

        <div class="">
          <div class="box" data-aos="zoom-in">
            <h3>Total Biaya Sparing</h3>
           
            <h4>Rp. {{ number_format($sparings->total_hadiah) }}</h4>
            <ul>
              <p>Tekan Tombol Bayar, & Pilih Metode Pembayaran</p>
            </ul>
            <button id="pay-button" type="submit">Bayar</button>
          </div>
        </div>
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
        <h2>Informasi</h2>
        <p>Detail Pembayaran Sparing</p>
      </div>

      <div class="row">
        <div class="invoice-box">
          <table>
            <tr class="top">
              <td colspan="2">
                <table>
                  <tr>
                    <td class="title">
                      <h4>Sparing ID : {{ $sparings['id'] }}</h4>
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
                      <b>{{ auth::user()->name }}</b>
                      <br>
                      Tanggal Order
                      <br>
                      <b>{{ $sparings['created_at'] }}</b>
                    </td>

                    <td>
                      Status Pembayaran<br />
                      @if(!$sparings)
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
                      <b>{{ $sparings['status'] }}</b>
                      <br>
                        Batas Waktu Pembayaran<br />
                        <b>{{ $deadline }}</b>
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
              @if($sparings->status == 'batal')
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
              <td>Pembayaran Lawan Sparing</td>

              <td>{{ number_format($sparings['total_hadiah']), 2}}</td>
            </tr>

            <tr class="item">
              <td>Diskon</td>

              <td>0</td>
            </tr>

            <tr class="total">
              <td></td>
              <td><b>Total: Rp. {{ number_format($gross_amount), 2}}</td>
              <td></td>
            </tr>
          </table>
          <br>
          <p>* Tunjukkan bukti pembayaran pada pihak operator saat di lokasi</p>
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