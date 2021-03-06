<!DOCTYPE html>
<html>
<head>
	<title>Rekap Laporan Donasi Yayasan At-Taufiq Kota Malang</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>

    <!-- <table style="border: 0px;">
        <tr style="border: 0px;">
            <td style="text-align: center;border: 0px;"><img style="width:80px;" src="{{ public_path().('admins/assets/images/logo-yayasan.png') }}"></td>
            <td style="text-align: center;border: 0px;"><b><br>
            Jl. Sanan No.70, Purwantoro<br>
            Kecamatan Blimbing, Kota Malang<br>
            Jawa Timur - 651222</b></td>
        </tr>
    </table> -->
    <center>
        <div class="row">
            <h5>YAYASAN AT-TAUFIQ KOTA MALANG</h4>
            <h5>Jl. Sanan No.70, Purwantoro</h4>
            <h5>Kecamatan Blimbing, Kota Malang</h4>
            <h5>Jawa Timur - 651222</h4>
        </div>
	</center>
    <hr>
    <br>
	<left>
		<h5>A. DONASI TRANSFER</h4>
	</left>

    <br>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Nomor Hp</th>
				<th>Pesan</th>
				<th>Nominal</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($online as $o)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$o->donatur_name}}</td>
				<td>{{$o->donatur_email}}</td>
				<td>{{$o->donatur_phone}}</td>
				<td>{{$o->message}}</td>
				<td> Rp. {{ number_format($o->nominal, 0) }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

    <br>

    <table class='table table-bordered'>
		<thead>
			<tr>
				<th>TOTAL</th>
				<th> Rp. {{ number_format($total, 0) }}</th>
			</tr>
		</thead>
	</table>

    <br>
    <hr>
    <br>

    <left>
		<h5>B. DONASI OFFLINE</h4>
	</left>

    <br>

    <table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Nomor Hp</th>
				<th>Pesan</th>
				<th>Nominal</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($offline as $of)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$of->nama}}</td>
				<td>{{$of->nohp}}</td>
				<td>{{$of->doa}}</td>
				<td> Rp. {{ number_format($of->nominal, 0) }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
    <br>
    <table class='table table-bordered'>
		<thead>
			<tr>
				<th>TOTAL</th>
				<th> Rp. {{ number_format($totalo, 0) }}</th>
			</tr>
		</thead>
	</table>

    <br>
    <hr>
    <br>

    <table class='table table-bordered'>
		<thead>
			<tr>
				<th>TOTAL MASUK UANG DONASI</th>
				<th> Rp. {{ number_format($total_semua, 0) }}</th>
			</tr>
		</thead>
	</table>
 
</body>
</html>