<?php

namespace App\Http\Controllers;

use App\Dao\Enums\CuciType;
use App\Dao\Enums\RegisterType;
use App\Dao\Models\Detail;
use App\Dao\Models\JenisLinen;
use App\Dao\Models\Rs;
use App\Dao\Models\Ruangan;
use App\Dao\Models\User;
use App\Dao\Models\ViewDetailLinen;
use App\Dao\Repositories\DetailRepository;
use Illuminate\Http\Request;

class ReportPenggantianLinenController extends MinimalController
{
    public $data;

    public function __construct(DetailRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm()
    {
        $rs = Rs::getOptions();
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
        $detail = Detail::getTableName();
        $jenis = JenisLinen::getTableName();
        $rs = Rs::getTableName();
        $ruangan = Ruangan::getTableName();
        $users = with(new User)->getTable();

        $query = Detail::query()
            ->select([
                $detail.'.'.Detail::field_primary().' as rfid_baru',
                $detail.'.detail_lama as rfid_lama',
                $detail.'.detail_status_cuci as detail_status_cuci',
                $detail.'.detail_status_register as detail_status_register',
                $detail.'.detail_pengantian_waktu as detail_pengantian_waktu',
                $jenis.'.'.JenisLinen::field_name().' as jenis_nama',
                $rs.'.'.Rs::field_name().' as rs_nama',
                $ruangan.'.'.Ruangan::field_name().' as ruangan_nama',
                $users.'.'.User::field_name().' as operator_name',
            ])
            ->leftJoin($jenis, $jenis.'.'.JenisLinen::field_primary(), '=', $detail.'.'.Detail::field_jenis_id())
            ->leftJoin($rs, $rs.'.'.Rs::field_primary(), '=', $detail.'.'.Detail::field_rs_id())
            ->leftJoin($ruangan, $ruangan.'.'.Ruangan::field_primary(), '=', $detail.'.'.Detail::field_ruangan_id())
            ->leftJoin($users, $users.'.'.User::field_primary(), '=', $detail.'.detail_pengantian_user')
            ->where(function ($sql) use ($detail) {
                $sql->whereNotNull($detail.'.detail_pengantian_waktu')
                    ->orWhereNotNull($detail.'.detail_lama');
            });

            if($request['filter_start'])
            {
                $query = $query->whereDate($detail.'.detail_pengantian_waktu', '>=', $request['filter_start']);
            }

            if($request['filter_end'])
            {
                $query = $query->whereDate($detail.'.detail_pengantian_waktu', '<=', $request['filter_end']);
            }

            if($request['view_rs_id'])
            {
                $query = $query->where($detail.'.'.Detail::field_rs_id(), $request['view_rs_id']);
            }

            if($request['view_ruangan_id'])
            {
                $query = $query->where($detail.'.'.Detail::field_ruangan_id(), $request['view_ruangan_id']);
            }

            if($request['view_linen_id'])
            {
                $query = $query->where($detail.'.'.Detail::field_jenis_id(), $request['view_linen_id']);
            }

            return $query->orderBy($jenis.'.'.JenisLinen::field_name(), 'ASC')->get();
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
