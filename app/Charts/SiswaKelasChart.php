<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Siswa;

class SiswaKelasChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $siswaKelas = Siswa::orderBy('kelas')->get();
        $data = [];
        $label = [];
        foreach (getNamaKelas() as $key => $value) {
            array_push($data, $siswaKelas->where('kelas', $value)->count());
            array_push($label, 'Kelas '.$value);
        }
        return $this->chart->donutChart()
            ->setTitle('Data Siswa PerKelas')
            ->setWidth(300)
            ->setHeight(300)
            ->setSubtitle(date('Y'))
            ->addData($data)
            ->setLabels($label);
    }
}
