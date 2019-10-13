<!DOCTYPE html>
<html lang="en">
<head>
	<title>Check</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	

<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('global/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('global/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('global/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('global/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('global/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('global/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('global/css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100">
					<table>
						<thead>
							<tr class="table100-head">
								<th class="column1">ID</th>
								<th class="column2">Nama</th>
								<th class="column3">Jenis</th>
								<th class="column4">Ukuran</th>
								<th class="column5">Stok</th>
                                <th class="column6">Satuan</th>
                                <th class="column6">Minimum</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($data as $monitoring)
                            <tr>
                              <td>{{ $monitoring->id }}</td>
                              <td>{{ $monitoring->nama }}</td>
                              <td>{{ $monitoring->jenis }}</td>
                              <td>{{ $monitoring->ukuran }}</td>
                              <td>{{ $monitoring->stok }}</td>
                              <td>{{ $monitoring->satuan }}</td>
                              <td>{{ $monitoring->jumlah_m }}</td>
                            </tr>
                          @endforeach
								
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="{{asset('global/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('global/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('global/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('global/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('global/js/main.js')}}"></script>

</body>
</html>