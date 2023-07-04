<!DOCTYPE html>
<html>

<head>
    <title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        h5 {
            font-size: 9pt;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="text-center">
        <h5 class="mb-4">Laporan Iuran Non SPP Tahun {{ $year }}</h5>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <!--<th>No</th>-->
                <th>Nomor Bukti</th>
                <th>Tanggal</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Iuran</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($result as $r)
            <tr>
                <!--<td>{{ $i++ }}</td>-->
                <td>{{ $r->trn }}</td>
                <td>{{ $r->date }}</td>
                <td>{{ $r->Student->nisn }}</td>
                <td>{{ $r->Student->fullname }}</td>
                <td>{{ $r->Due->name }}</td>
                <td>{{ $r->description }}</td>
                <td class="text-right">{{ number_format($r->amount) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>