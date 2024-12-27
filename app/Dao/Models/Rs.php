<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\RsEntity;
use App\Dao\Enums\UserLevel;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\ApiTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use App\Http\Resources\GeneralResource;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class Rs extends Model
{
    use ActiveTrait, ApiTrait, DataTableTrait, FilterQueryString, OptionTrait, PowerJoins, RsEntity, Sanitizable, Sortable;

    protected $table = 'rs';

    protected $primaryKey = 'rs_id';

    protected $fillable = [
        'rs_id',
        'rs_nama',
        'rs_alamat',
        'rs_deskripsi',
        'rs_harga_cuci',
        'rs_harga_sewa',
        'rs_aktif',
        'rs_code',
        'rs_status',
    ];

    public $sortable = [
        'rs_nama',
        'rs_deskripsi',
    ];

    protected $casts = [
        'rs_id' => 'integer',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;

    public $incrementing = true;

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        $data = [
            DataBuilder::build($this->field_primary())->name('ID')->width(20)->sort(),
            DataBuilder::build($this->field_code())->name('Kode RS')->show()->sort(),
            DataBuilder::build($this->field_name())->name('Nama Rumah Sakit')->show()->sort(),
            DataBuilder::build($this->field_alamat())->name('Alamat')->show()->sort(),
            DataBuilder::build($this->field_description())->name('Deskripsi')->show()->sort(),
        ];

        if (level(UserLevel::Finance)) {
            $data = array_merge($data, [
                DataBuilder::build($this->field_harga_cuci())->name('Harga Cuci')->show()->sort(),
                DataBuilder::build($this->field_harga_sewa())->name('Harga Rental')->show()->sort(),
            ]);
        }

        return $data;
    }

    public function apiTransform()
    {
        return GeneralResource::class;
    }

    public function has_ruangan()
    {
        return $this->belongsToMany(Ruangan::class, 'rs_dan_ruangan', Rs::field_primary(), Ruangan::field_primary());
    }

    public function has_jenis()
    {
        return $this->belongsToMany(JenisLinen::class, 'rs_dan_jenis', Rs::field_primary(), JenisLinen::field_primary())->withPivot(['parstock']);
    }

    public function has_rfid()
    {
        return $this->hasMany(Detail::class, Detail::field_rs_id(), $this->field_primary());
    }
}
