<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Transaksi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ public_path('admin/assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{ public_path('admin/assets/css/bootstrap.min.css')}}">
    <style>
        body{
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color:#333;
            text-align:left;
            font-size:18px;
            margin:0;
        }
        .container{
            margin:0 auto;
            margin-top:35px;
            padding:40px;
            width:750px;
            height:auto;
            background-color:#fff;
        }
        .abu{
          background-color: #f0f0f0;
        }
        .header{
            margin-bottom: 20px;
        }
        caption{
            font-size:28px;
            margin-bottom:15px;
        }
        table{
            border:1px solid #333;
            border-collapse:collapse;
            margin:0 auto;
            width:1000px;
        }
        td, tr, th{
            padding:12px;
            border:1px solid #333;
            /*width:185px;*/
        }
        th{
            background-color: #f0f0f0;
        }
        h4, p{
            margin:0px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="pull-left" src="{{ public_path('admin/images/reksakepil_hitam.png') }}" style="max-width:15%;">
        <hr>

    </div>
    <table>
            
            <thead>
                <tr>
                    <th style="max-width: 5px;">#</th>
                    <th>Kode Transaksi</th>
                    <th>Nasabah</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                </tr>
                @php ($i = 1);
                @foreach($earnings as $val)
                <tr>
                    <td>{{ $i++ }}.</td>
                    <td>{{ $val->code }}</td>
                    <td>{{ ucfirst($val->name) }}</td>
                    <td style="max-width: 50px;">{{ $val->created_at->translatedFormat('d F Y')}}</td>
                    <td>Rp. {{ number_format($val->sum('earning')) }}</td>
                </tr>
                @endforeach
            </thead>
        </table>
</body>
</html>