<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class TagihanBulananChart
{
    protected $chart;
    protected array $data = [];
    protected array $label = [];

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $data): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        return $this->chart->donutChart()
            ->setDataLabels(true)
            ->setWidth(165)
            ->setHeight(165)
            ->setSparkline(true)
            ->addData($data);
    }
}
