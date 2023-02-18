<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>
        {{ @$title != '' ? "$title |" : '' }} {{ settings()->get('app_name', 'My APP') }}
    </title>

    <style>
        * {
            color: black;
        }

        .invoice-box {
            background-color: #93c5fd;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }

        hr {
            margin: 0 0;
            padding: 0 0;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.53;
            color: #697a8d;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.4375rem 1.25rem;
            font-size: 0.9375rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
            text-decoration: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #696cff;
            border-color: #696cff;
            box-shadow: 0 0.125rem 0.25rem 0 rgb(105 108 255 / 40%);
        }

        .table-tagihan {
            border: 1px solid black;
            border-spacing: 0px;
        }

        .table-tagihan th {
            padding: 4px;
            border: 1px solid black;
        }

        .table-tagihan td {
            padding: 4px;
            border: 1px solid black;
        }

        @media print {
            @page {
                size: A4 portrait;
            }

            .tombol {
                display: none;
            }

            .invoice-box {
                background-color: #93c5fd !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            @include('components.header_invoice_kartu')

            <tr class="information">
                <td colspan="3">
                    <table>
                        <tr>
                            <td
                                style="text-align: center; font-size: 24px; font-weight:bold; padding:0px; padding-bottom: 20px;">
                                Tahun Ajaran {{ getTahunAjaranFull(request('bulan'), request('tahun')) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0px;">
                                Nama Siswa : {{ $siswa->nama }} ({{ $siswa->nisn }})<br />
                                Kelas : {{ $siswa->kelas }}<br />
                                Jurusan : {{ $siswa->jurusan }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table width="100%" class="table-tagihan">
                        <tr class="heading">
                            <th style="text-align: center">No</th>
                            <th style="text-align: start">Bulan</th>
                            <th style="text-align: center">Tanggal Bayar</th>
                            <th style="text-align: end">Jumlah Tagihan</th>
                            <th>Paraf</th>
                            <th>Keterangan</th>
                        </tr>

                        @foreach ($kartuSpp as $item)
                            <tr class="item">
                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                <td style="text-align: start">{{ $item['bulan'] . ' ' . $item['tahun'] }}</td>
                                <td style="text-align: center">{{ $item['tanggal_bayar'] }}</td>
                                <td style="text-align: end">{{ formatRupiah($item['total_tagihan']) }}</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="3">
                    Jambi, {{ now()->translatedFormat('d, F Y') }} <br>
                    @include('components.informasi_pj')
                </td>
            </tr>
        </table>
        @if (request('output') != 'pdf')
            <center style="margin-top: 20px;" class="tombol">
                <a class="btn btn-primary" href="{{ url()->full() . '&output=pdf' }}">Download PDF</a>
                <a class="btn btn-primary" href="#" onclick="window.print()">Cetak</a>
            </center>
        @endif
    </div>
</body>

</html>
