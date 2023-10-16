<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
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
        <h5 class="mb-4">{{ $title }}</h5>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <!--<th>No</th>-->
                <th>Rek</th>
                <th>Nama</th>
                <th>Awal</th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>Mei</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Ags</th>
                <th>Sep</th>
                <th>Okt</th>
                <th>Nov</th>
                <th>Des</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach($result as $r)
            <tr>
                <!--<td>{{ $i++ }}</td>-->
                <td>{{ $r->code }}</td>
                <td>{{ $r->name }}</td>
                <td class="text-right">{{ number_format($r->M00) }}</td>
                <td class="text-right">{{ number_format($r->M01) }}</td>
                <td class="text-right">{{ number_format($r->M02) }}</td>
                <td class="text-right">{{ number_format($r->M03) }}</td>
                <td class="text-right">{{ number_format($r->M04) }}</td>
                <td class="text-right">{{ number_format($r->M05) }}</td>
                <td class="text-right">{{ number_format($r->M06) }}</td>
                <td class="text-right">{{ number_format($r->M07) }}</td>
                <td class="text-right">{{ number_format($r->M08) }}</td>
                <td class="text-right">{{ number_format($r->M09) }}</td>
                <td class="text-right">{{ number_format($r->M10) }}</td>
                <td class="text-right">{{ number_format($r->M11) }}</td>
                <td class="text-right">{{ number_format($r->M12) }}</td>
                <td class="text-right">{{ number_format($r->M00+$r->M01+$r->M02+$r->M03+$r->M04+$r->M05+$r->M06+$r->M07+$r->M08+$r->M09+$r->M10+$r->M11+$r->M12) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>