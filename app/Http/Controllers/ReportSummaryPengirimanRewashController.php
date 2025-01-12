<?php

namespace App\Http\Controllers;

use App\Dao\Enums\TransactionType;
use App\Dao\Models\Bersih;
use App\Dao\Models\Rs;
use App\Dao\Models\Transaksi;
use App\Dao\Models\User;
use App\Dao\Repositories\BersihRepository;
use App\Dao\Repositories\TransaksiRepository;
use App\Http\Requests\DeliveryReportRequest;
use Illuminate\Support\Facades\DB;
use Plugins\Query;

class ReportSummaryPengirimanRewashController extends MinimalController
{
    public $data;

    public function __construct(BersihRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {

        $rs = Query::getRs();
        $user = User::getOptions();

        self::$share = [
            'user' => $user,
            'rs' => $rs,
        ];
    }

    private function getQuery($request)
    {
        $query = self::$repository->getReport()->where(Bersih::field_status(), TransactionType::REWASH)
        ->select([
            'view_bersih.*',
            DB::raw('count(bersih_rfid) as total_rfid'),
        ]);

        if ($start_date = $request->start_delivery) {
            $query = $query->where(Bersih::field_report(), '>=', $start_date);
        }

        if ($end_date = $request->end_delivery) {
            $query = $query->where(Bersih::field_report(), '<=', $end_date);
        }

        $query = $query->get();

        if ($query->sum('total_rfid') > 0) {
            return $query;
        }

        return [];
    }

    public function getPrint(DeliveryReportRequest $request)
    {
        set_time_limit(0);
        $rs = Rs::find(request()->get(Rs::field_primary()));

        $this->data = $this->getQuery($request);

        return moduleView(modulePathPrint(), $this->share([
            'data' => $this->data,
            'rs' => $rs,
        ]));
    }
}
