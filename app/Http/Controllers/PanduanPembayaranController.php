<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanPembayaranController extends Controller
{
    public function index($via)
    {
        if($via == 'atm'){
            return view('panduan_pembayaran_atm');
        }

        if($via == 'internet.banking'){
            return view('panduan_pembayaran_ib');
        }
    }
}
