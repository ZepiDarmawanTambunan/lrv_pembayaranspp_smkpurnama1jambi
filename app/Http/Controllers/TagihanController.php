<?php

namespace App\Http\Controllers;

use App\Models\Tagihan as Model;
use App\Models\Siswa;
use App\Models\TagihanDetail;
use App\Models\Pembayaran;
use App\Http\Requests\StoreTagihanRequest;
use App\Jobs\ProcessTagihanStore;
use App\Models\Biaya;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TagihanNotification;
use Carbon\Carbon;
use DB;

class TagihanController extends Controller
{
    private $viewIndex = 'tagihan_index';
    private $viewCreate = 'tagihan_form';
    private $viewEdit = 'tagihan_form';
    private $viewShow = 'tagihan_show';
    private $routePrefix = 'tagihan';

    public function index(Request $request)
    {
        $models = Model::latest();
        if ($request->filled('bulan')) {
            $models->whereMonth('tanggal_tagihan', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $models->whereYear('tanggal_tagihan', $request->tahun);
        }
        if ($request->filled('status')) {
            $models->where('status', $request->status);
        }
        if ($request->filled('biaya_id')) {
            $models->where('biaya_id', $request->biaya_id);
        }
        if ($request->filled('q')) {
            $models->search($request->q, null, true);
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', '20')),
            'routePrefix' => $this->routePrefix,
            'title' => 'DATA TAGIHAN',
            'biayaList' => Biaya::whereNull('parent_id')->pluck('nama', 'id'),
        ]);
    }

    public function create()
    {
        $siswa = Siswa::all();
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'FORM DATA TAGIHAN',
            'siswaList' => $siswa->pluck('nama', 'id'),
            // 'angkatan' => $siswa->pluck('angkatan', 'angkatan'),
            // 'kelas' => $siswa->pluck('kelas', 'kelas'),
            // 'biaya' => Biaya::get(),
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    public function store(StoreTagihanRequest $request)
    {
        $requestData = array_merge($request->validated(), ['user_id' => auth()->user()->id]);
        $processTagihan = new ProcessTagihanStore($requestData);
        $this->dispatch($processTagihan);
        // return redirect()->action('\Imtigger\LaravelJobStatus\ProgressController@progress', [$processTagihan->getJobStatusId()]);
        return redirect()->route('jobstatus.index', ['job_status_id' => $processTagihan->getJobStatusId()]);
        // flash('Data berhasil ditambahkan');
        // return redirect()->route('tagihan.index');
    }

    public function show(Request $request, $id)
    {
        $tahun = $request->tahun;
        if ($request->bulan < bulanSpp()[0]) {
            $tahun = $tahun - 1;
        }
        $arrayData = [];
        foreach (bulanSPP() as $bulan) {
            if ($bulan == 1) {
                $tahun = $tahun + 1;
            }

            $tagihan = Model::where('siswa_id', $request->siswa_id)
                ->whereMonth('tanggal_tagihan', $bulan)
                ->whereYear('tanggal_tagihan', $tahun)
                ->first();

            $tanggalBayar = '';
            if ($tagihan != null && $tagihan->status != 'baru') {
                $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/y');
            }

            $arrayData[] = [
                'bulan' => ubahNamaBulan($bulan),
                'tahun' => $tahun,
                'total_tagihan' => $tagihan->total_tagihan ?? 0,
                'status_tagihan' => ($tagihan == null) ? false : true,
                'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                'tanggal_bayar' => $tanggalBayar,
            ];
        }
        $data['kartuSpp'] = collect($arrayData);

        $tagihan = Model::with('pembayaran')->findOrFail($id);
        $data['model'] = new Pembayaran();
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = $tagihan->tanggal_tagihan->translatedFormat('F Y');
        return view('operator.' . $this->viewShow, $data);
    }

    public function destroy(Model $tagihan)
    {
        if ($tagihan->status == 'lunas') {
            flash()->AddError("Data tagihan tidak bisa dihapus karena sudah dibayar");
            return back();
        }
        $tagihan->delete();
        flash("Data berhasil dihapus");
        return back();
    }
}
