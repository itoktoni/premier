<?php

namespace App\Http\Services;

use App\Dao\Enums\CetakType;
use App\Dao\Enums\HilangType;
use App\Dao\Enums\LogType;
use App\Dao\Enums\ProcessType;
use App\Dao\Models\Bersih;
use App\Dao\Models\Cetak;
use App\Dao\Models\Outstanding;
use App\Dao\Models\Transaksi;
use App\Dao\Models\ViewDetailLinen;
use Illuminate\Support\Facades\DB;
use Plugins\History;
use Plugins\Notes;

class UpdatePackingService
{
    public function update($data)
    {
        $passing = $return = [];

        DB::beginTransaction();
        try {
            Bersih::insert($data->bersih);

            Outstanding::whereIn(Outstanding::field_primary(), $data->rfid)
                ->update([
                    Outstanding::field_rs_ori() => $data->rs_id,
                    Outstanding::field_ruangan_id() => $data->ruangan_id,
                    Outstanding::field_status_process() => ProcessType::PACKING,
                    Outstanding::field_updated_at() => date('Y-m-d H:i:s'),
                    Outstanding::field_status_hilang() => HilangType::NORMAL,
                    Outstanding::field_hilang_created_at() => null,
                    Outstanding::field_pending_created_at() => null,
                ]);

            History::bulk($data->rfid, LogType::PACKING, 'Assign to Rs '.$data->rs_name, $data->rs_id);

            // CETAK PRINT

            $code = $data->uuid;
            $total = Bersih::where(Bersih::field_barcode(), $code)
                ->addSelect([
                    'bersih_rfid',
                    'bersih_id_rs',
                    'bersih_id_ruangan',
                    'bersih_barcode',
                    'bersih_delivery',
                    'bersih_status',
                    'bersih_created_at',
                    'rs_nama',
                    'ruangan_nama',
                    'jenis_id',
                    'jenis_nama',
                    'name',
                ])
                ->leftJoinRelationship('has_rs')
                ->leftJoinRelationship('has_ruangan')
                ->leftJoinRelationship('has_user')
                ->leftJoinRelationship('has_detail.has_jenis')
                ->get();

            $data = null;

            if ($total->count() > 0) {

                $cetak = Cetak::where(Cetak::field_name(), $code)->first();
                if (! $cetak) {
                    $cetak = Cetak::create([
                        Cetak::field_date() => date('Y-m-d'),
                        Cetak::field_name() => $code,
                        Cetak::field_type() => CetakType::Barcode,
                        Cetak::field_user() => auth()->user()->name ?? null,
                        Cetak::field_rs_id() => $total[0]->bersih_id_rs ?? null,
                    ]);
                }

                $data = $total->mapToGroups(function ($item) {
                    $parse = [
                        'id' => $item->jenis_id,
                        'nama' => $item->jenis_nama,
                        'rs' => $item->rs_nama,
                        'lokasi' => $item->ruangan_nama,
                        'status' => $item->bersih_status,
                        'tgl' => formatDate($item->bersih_created_at, 'd/M/Y'),
                    ];

                    return [$item['jenis_id'].'#'.$item['ruangan_id'] => $parse];
                });

                $no = 1;
                foreach ($data as $item) {
                    $return[] = [
                        'id' => $no,
                        'code' => $code,
                        'tgl' => $item[0]['tgl'] ?? null,
                        'rs' => $item[0]['rs'] ?? null,
                        'nama' => $item[0]['nama'] ?? null,
                        'lokasi' => $item[0]['lokasi'] ?? null,
                        'status' => $item[0]['status'] ?? null,
                        'user' => auth()->user()->name ?? null,
                        'total' => count($item),
                    ];

                    $no++;
                }
            }

            DB::commit();

            return Notes::data($return, $passing);

        } catch (\Throwable $th) {
            DB::rollBack();

            return Notes::error($th->getMessage());
        }
    }
}
