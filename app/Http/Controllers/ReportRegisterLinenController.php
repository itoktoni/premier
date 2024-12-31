<?php

namespace App\Http\Controllers;

use App\Dao\Enums\CuciType;
use App\Dao\Enums\RegisterType;
use App\Dao\Models\JenisLinen;
use App\Dao\Models\Rs;
use App\Dao\Models\Ruangan;
use App\Dao\Models\ViewDetailLinen;
use App\Dao\Repositories\DetailRepository;
use Illuminate\Http\Request;
use Plugins\Query;

class ReportRegisterLinenController extends MinimalController
{
    public $data;

    public function __construct(DetailRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {

        $rs = Query::getRs();
        $jenis = JenisLinen::getOptions();
        $ruangan = Ruangan::getOptions();
        $cuci = CuciType::getOptions();
        $register = RegisterType::getOptions();

        self::$share = [
            'rs' => $rs,
            'ruangan' => $ruangan,
            'jenis' => $jenis,
            'register' => $register,
            'cuci' => $cuci,
        ];
    }

    private function getQuery($request)
    {
        return self::$repository->getConfig()->orderBy('view_linen_nama', 'ASC')->get();
    }

    public function getPrint(Request $request)
    {
        set_time_limit(0);
        $rs = Rs::find(request()->get(ViewDetailLinen::field_rs_id()));

        $this->data = $this->getQuery($request);

        return moduleView(modulePathPrint(), $this->share([
            'data' => $this->data,
            'rs' => $rs,
        ]));
    }
}
