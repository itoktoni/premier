<?php

namespace App\Charts;

use App\Dao\Enums\TransactionType;
use App\Dao\Models\Bersih;
use App\Dao\Models\Transaksi;
use App\Dao\Models\ViewBersih;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class DashboardBersihHarian
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
        if ($rs_id) {

            $data_bersih = DB::table('view_rekap_bersih')
            ->select(['view_ruangan_nama', DB::raw('sum(view_qty) as total')])
                ->where('view_rs_id', $rs_id)
                ->where('view_tanggal', now()->format('Y-m-d'))
                ->where('view_status', TransactionType::BERSIH)
                ->groupBy('view_ruangan_id', 'view_rs_id')
                ->orderBy('view_ruangan_nama')
                ->get();

            $ruangan = $data_bersih->pluck('view_ruangan_nama')->toArray();
            $data_total = $data_bersih->pluck('total')->toArray();

            $total = array_map('intval', $data_total);
        }

        return $this->chart->donutChart()
            ->setSubtitle('Tanggal '.Carbon::now()->format('d/m/Y'))
            ->setLabels($ruangan)
            ->addData($total)
            ->setTitle('Sebaran Linen Bersih');
    }
}
