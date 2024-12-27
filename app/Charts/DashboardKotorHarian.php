<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardKotorHarian
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle('Sebaran Linen di Rs. Premier Bintaro')
            ->setSubtitle('Tanggal 27-12-2024.')
            ->addData([104, 300, 500])
            ->setLabels(['Duk', 'Baju Dokter', 'Handuk']);
    }
}
