<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;

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
        for($i = 0; $i < count($request->tagihan_id); $i++){
            $tagihan = Tagihan::where('id', $request->tagihan_id[$i])->first();
            if($tagihan != null && $tagihan->status != 'lunas'){
                // delete tagihan
                $tagihan->delete();
            }
        }
        return response()->json([
            'message' => 'Data berhasil dihapus',
        ], 200);
    }
}
