<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardBersihHarian
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        return $this->chart->lineChart()
            ->setTitle('Perbandingan Bersih dan Kotor Minggu ini')
            ->setSubtitle('Bersih vs Kotor.')
            ->addData('Bersih', [40, 93, 35, 42, 18, 82])
            ->addData('Kotor', [70, 29, 77, 28, 55, 45])
            ->setXAxis(['Tgl 01', 'Tgl 02', 'Tgl 03', 'Tgl 04', 'Tgl 05', 'Tgl 06']);
    }
}
