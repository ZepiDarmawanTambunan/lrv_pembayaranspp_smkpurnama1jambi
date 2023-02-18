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
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
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
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
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
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
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

        .invoice-box table tr td {
            border-bottom: 1px solid black;
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
            <tr>
                <td width="25%">No.</td>
                <td>: #{{ $pembayaran->id }}</td>
            </tr>
            <tr>
                <td>Telah terima dari</td>
                <td>: {{ $pembayaran->tagihan->siswa->nama }}</td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>
                    <i>
                        : {{ ucwords(terbilang($pembayaran->jumlah_dibayar)) }} RUPIAH
                    </i>
                </td>
            </tr>
            <tr>
                <td>Untuk pembayaran</td>
                <td>: SPP {{ $pembayaran->tagihan->tanggal_tagihan->translatedFormat('F Y') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <br><br>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table>
                        <tr>
                            <td colspan="2" style="vertical-align: bottom">
                                <div style="background-color: #eee; width: 100px; padding:10px;font-weight:bold;">
                                    {{ formatRupiah($pembayaran->jumlah_dibayar) }}
                                </div>
                            </td>
                            <td style="text-align: right;">
                                Jambi, {{ $pembayaran->tanggal_bayar->translatedFormat('d, F Y') }} <br>
                                @include('components.informasi_pj')
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        @if (request('output') == null)
            <center style="margin-top: 20px;" class="tombol">
                <a class="btn btn-primary" href="{{ url()->current() . '?output=pdf' }}">Download PDF</a>
                <a class="btn btn-primary" href="#" onclick="window.print()">Cetak</a>
            </center>
        @endif
    </div>
</body>

</html>
