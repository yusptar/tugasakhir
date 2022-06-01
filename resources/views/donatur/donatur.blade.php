@extends('layouts.template')
@section('content')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="SB-Mid-client-fSW1kufnC6UkZ0G6"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->

    <!-- ======= Donasi Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="section-title">
          <h2>Donasi</h2>
          <p></p>
        </div>
      </div>

      <div class="container">
        <div class="row mt-5">
          <div class="col-lg-8 mt-5 mt-lg-0">
            <form method="POST" action="" id="submit_form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                @csrf
                  <input type="hidden" name="json" id="json_callback">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" value="{{ $user->name }}" required>
                  <!-- <label class="form-label">
                    <input x-model="hide_identity" name="anonymous" type="checkbox">
                    <span class="text-xs italic">Sembunyikan nama (Hamba Allah)</span>
                  </label> -->
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" value="{{ $user->email }}" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="gross_amount" class="form-label">Jumlah Donasi</label>
                <input type="text" class="form-control" name="gross_amount" id="rupiah" placeholder="Rp. " required>
              </div>
              <div class="form-group mt-3">
                <label for="message" class="form-label">Pesan ( Opsional )</label>
                <textarea class="form-control" name="message" rows="5" placeholder="Tulis pesan atau do'a ... "></textarea>
              </div>
              <br>
              <div class="text-center"><button type="submit" id="confirm-button">Konfirmasi Donasi</button></div>
            </form>
            @if(session('alert-success'))
            <script>alert("{{session('alert-success')}}")</script>
            @elseif(session('alert-failed'))
            <script>alert("{{session('alert-failed')}}")</script>
            @endif
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

    <!-- ======= Riwayat Donasi Section ======= -->
    <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title">
          <h2>Riwayat Donasi</h2>
        </div>

    
      <!-- Main Body -->
      <div class="container">
          <div class="row">
            <div class="riwayat">
                <div class="comment mt-4 text-justify float-left">
                    <img src="{{asset('/storage/images/'.Auth::user()->image)}}" alt="" class="rounded-circle" width="60" height="60">
                    <br>
                    <h4>Donatur Name</h4>
                    <span>Rp. 1.500.000, &nbsp;10 April 2022</span>
                    <br>
                    <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                </div>
                <div class="comment mt-4 text-justify float-left">
                    <img src="{{asset('/storage/images/'.Auth::user()->image)}}" alt="" class="rounded-circle" width="60" height="60">
                    <br>
                    <h4>Donatur Name</h4>
                    <span>Rp. 1.500.000, &nbsp;10 April 2022</span>
                    <br>
                    <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                </div>
                <div class="comment mt-4 text-justify float-left">
                    <img src="{{asset('/storage/images/'.Auth::user()->image)}}" alt="" class="rounded-circle" width="60" height="60">
                    <br>
                    <h4>Donatur Name</h4>
                    <span>Rp. 1.500.000, &nbsp;10 April 2022</span>
                    <br>
                    <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- Riwayat Donasi Section -->

    <script type="text/javascript">
   
      var payButton = document.getElementById('confirm-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $snap_token }}', {
          onSuccess: function(result){
            
            console.log(result);
            send_response_to_form(result);
          },
          onPending: function(result){
            
             console.log(result);
             send_response_to_form(result);
          },
          onError: function(result){
            
             console.log(result);
             send_response_to_form(result);
          },
          onClose: function(){
            
            alert('you closed the popup without finishing the payment');
          }
        })
      });

      function send_response_to_form(result){
        document.getElementById('json_callback').value = JSON.stringify(result);
        $('#submit_form').submit();
      }

      var rupiah = document.getElementById('rupiah');
      rupiah.addEventListener('keyup', function(e){
        rupiah.value = formatRupiah(this.value, 'Rp. ');
      });
  
      /* Fungsi Format Rupiah */
      function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
  
        if(ribuan){
          separator = sisa ? '.' : '';
          rupiah += separator + ribuan.join('.');
        }
  
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
      }
    </script>

@endsection