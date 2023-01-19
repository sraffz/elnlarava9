<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <p align="center"><img src="{{ asset('adminlte/dist/img/kelantan.png')}}" width="200" height="150" alt="User Image" align="center"><br></p>
  <p align="center"><strong>PERMOHONAN PERJALANAN PEGAWAI AWAM KE LUAR NEGARA ATAS URUSAN RASMI/PERSENDIRIAN<BR>BAGI BIL /2021 </strong></p>            
  <table class="table">
    <thead>
      <tr border="1">
        <th>BIL</th>
        <th>NEGERA</th>
        <th>NAMA</th>
        <th>JAWATAN</th>
        <th>JABATAN</th>
        <th>TARIKH PERGI</th>
        <th>TARIKH BALIK</th>
        <th>SUMBER KEWANGAN</th>
       
      </tr>
    </thead>
      @php $no=1; @endphp

      <tbody>
        @foreach($info as $mohonan)
        <tr>
            <td>@php echo $no; $no=$no+1; @endphp</td>
            <td>{{ $mohonan->negara }}</td>
            <td>{{ $mohonan->user->nama }}</td>
            <td>{{ $mohonan->user->userJawatan->namaJawatan }}</td>
            <td>{{ $mohonan->user->userJabatan->kod_jabatan }}</td>
            <td>{{\Carbon\Carbon::parse($mohonan->tarikhMulaPerjalanan)->format('d/m/Y')}}</td>
            <td>{{\Carbon\Carbon::parse($mohonan->tarikhAkhirPerjalanan)->format('d/m/Y')}}</td>
            <td>{{ $mohonan->jenisKewangan }}</td>
        </tr>
        @endforeach
      </tbody>
  </table>
</div>

</body>
</html>
