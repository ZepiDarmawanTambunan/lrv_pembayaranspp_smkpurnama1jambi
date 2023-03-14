<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Http\Controllers\Controller;

class TagihanDestroy extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $berhasilDihapus = 0;
        $gagalDihapus = 0;
        $message = 'Data berhasil dihapus';

        for ($i = 0; $i < count($request->tagihan_id); $i++) {
            $tagihan = Tagihan::where('id', $request->tagihan_id[$i])->first();
            if ($tagihan != null && $tagihan->status != 'lunas') {
                // delete tagihan
                $tagihan->delete();

                $berhasilDihapus += 1;
            } else {
                $gagalDihapus += 1;
            }
        }
        $message  = $message . ' : ' . $berhasilDihapus;
        if ($gagalDihapus > 0) {
            $message = $message . ' | Data gagal dihapus : ' . $gagalDihapus;
        }

        return response()->json([
            'message' => $message,
        ], 200);
    }
}
