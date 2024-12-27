<?php

namespace App\Http\Controllers;

use App\Dao\Enums\TransactionType;
use App\Dao\Models\Rs;
use App\Dao\Models\Transaksi;
use App\Dao\Models\User;
use App\Dao\Models\ViewDetailLinen;
use App\Dao\Repositories\TransaksiRepository;
use App\Http\Requests\RekapReportRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRekapLinenBaruController extends MinimalController
{
    public $data;

    public function __construct(TransaksiRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {

        $rs = Rs::getOptions();
        $user = User::getOptions();

        self::$share = [
            'user' => $user,
            'rs' => $rs,
        ];
    }

    private function getQueryBersih($request)
    {
        $query = self::$repository->getDetailAllBersih([TransactionType::REGISTER]);

        if ($start_date = $request->start_rekap) {
            $query = $query->whereDate(Transaksi::field_report(), '>=', $start_date);
        }

        if ($end_date = $request->end_rekap) {
            $query = $query->whereDate(Transaksi::field_report(), '<=', $end_date);
        }

        return $query->get();
    }

    private function getQueryKotor($request)
    {
        $query = DB::table('view_rekap_kotor')
        ->where('view_rs_id', $request->rs_id)
        ->where('view_status', TransactionType::REGISTER)
        ;

        if ($start_date = $request->start_rekap) {
            $query = $query->where('view_tanggal', '>=', $start_date);
        }

        if ($end_date = $request->end_rekap) {
            $query = $query->where('view_tanggal', '<=', $end_date);
        }


        return $query->get();
    }

    public function getPrint(RekapReportRequest $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $location = $linen = $lawan = [];

        $rs = Rs::find(request()->get(Rs::field_primary()));
        $kotor = $this->getQueryKotor($request);
        $linen = $kotor->sortBy(ViewDetailLinen::field_name())->pluck(ViewDetailLinen::field_name(), ViewDetailLinen::field_id());
        $location = $kotor->sortBy(ViewDetailLinen::field_ruangan_name())->pluck(ViewDetailLinen::field_ruangan_name(), ViewDetailLinen::field_ruangan_id());

        return moduleView(modulePathPrint(), $this->share([
            'data' => $this->data,
            'rs' => $rs,
            'location' => $location,
            'linen' => $linen,
            'kotor' => $kotor,
        ]));
    }
}
