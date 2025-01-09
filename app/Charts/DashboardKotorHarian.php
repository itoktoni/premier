<?php

namespace App\Charts;

use App\Dao\Enums\TransactionType;
use App\Dao\Models\ViewDetailLinen;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardKotorHarian
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $ruangan = $total = [];
        $rs_id = auth()->user()->rs_id;
        $tanggal = now()->subDay(1)->format('Y-m-d');

        if ($rs_id) {
            $data_bersih = DB::table('view_rekap_kotor')
            ->select(['view_ruangan_nama', DB::raw('sum(view_qty) as total')])
                ->where('view_rs_id', $rs_id)
                ->where('view_tanggal', $tanggal)
                ->where('view_status', TransactionType::KOTOR)
                ->groupBy('view_ruangan_id', 'view_rs_id')
                ->orderBy('view_ruangan_nama')
                ->get();

            $ruangan = $data_bersih->pluck('view_ruangan_nama')->toArray();
            $data_total = $data_bersih->pluck('total')->toArray();

            $total = array_map('intval', $data_total);
        }

        return $this->chart->donutChart()
            ->setSubtitle('Tanggal '.formatDate($tanggal))
            ->setLabels($ruangan)
            ->addData($total)
            ->setTitle('Sebaran Linen Kotor');
    }
}
