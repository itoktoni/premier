<?php

namespace App\Charts;

use App\Dao\Enums\TransactionType;
use App\Dao\Models\Bersih;
use App\Dao\Models\Transaksi;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardBersihHarian
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $start_date = Carbon::now()->subDay(7);
        $end_date = Carbon::now();
        $range = CarbonPeriod::create($start_date, $end_date)->toArray();
        $bersih = [];
        $kotor = [];

        $rs_id = auth()->user()->rs_id;
        if ($rs_id)
        {
            $data_bersih = Bersih::where(Bersih::field_rs_id(), auth()->user()->rs_id)
                ->where(Bersih::field_report(), '>=', $start_date->format('Y-m-d'))
                ->where(Bersih::field_report(), '<=', $end_date->format('Y-m-d'))
                ->where(Bersih::field_status(), TransactionType::BERSIH)
                ->showSql()->get();

            $data_kotor = Transaksi::where(Transaksi::field_rs_ori(), auth()->user()->rs_id)
                ->whereDate(Transaksi::field_created_at(), '>=', $start_date->format('Y-m-d'))
                ->whereDate(Transaksi::field_created_at(), '<=', $end_date->format('Y-m-d'))
                ->where(Transaksi::field_status_transaction(), TransactionType::KOTOR)
                ->showSql()->get()->map(function($item){
                    $item['tanggal'] = $item->transaksi_created_at->format('Y-m-d') ?? null;
                    return $item;
                });
        }

        foreach($range as $dates){
            $date[] = $dates->format('m-d');
            $bersih[] = $data_bersih->where(Bersih::field_report(), $dates->format('Y-m-d'))->count();
            $kotor[] = $data_kotor->where('tanggal', $dates->format('Y-m-d'))->count();
        }


        return $this->chart->barChart()
            ->setTitle('Perbandingan Bersih dan Kotor 7 hari kebelakang')
            ->setSubtitle('Bersih vs Kotor.')
            ->addData('Bersih', $bersih)
            ->addData('Kotor', $kotor)
            ->setXAxis($date);
    }
}
