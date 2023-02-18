<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaliNotifikasiController extends Controller
{
    public function update(Request $request, $id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->first()?->markAsRead();
        flash('Data sudah diubah');
        return back();
    }
}
