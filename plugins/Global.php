<?php

use App\Dao\Enums\TransactionType;
use App\Dao\Models\Rs;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Str;
use Plugins\Notes;
//use Plugins\SharedData;
use Coderello\SharedData\Facades\SharedData;

define('ACTION_CREATE', 'getCreate');
define('ACTION_UPDATE', 'getUpdate');
define('ACTION_DELETE', 'getDelete');
define('ACTION_EMPTY', 'empty');
define('ACTION_TABLE', 'getTable');
define('ACTION_PRINT', 'getPrint');
define('ACTION_EXPORT', 'getExport');
define('ERROR_PERMISION', 'Maaf anda tidak punya otorisasi untuk melakukan hal ini');

define('VIEW_DETAIL_LINEN', 'view_detail_linen');

define('HAS_RS', 'has_rs');
define('HAS_SUPPLIER', 'has_supplier');
define('HAS_RS_DELIVERY', 'has_rs_delivery');
define('HAS_RUANGAN', 'has_ruangan');
define('HAS_RFID', 'has_rfid');
define('HAS_JENIS', 'has_jenis');
define('HAS_BAHAN', 'has_bahan');
define('HAS_DETAIL', 'has_detail');
define('HAS_OUTSTANDING', 'has_outstanding');
define('HAS_CUCI', 'has_cuci');
define('HAS_PEMAKAIAN', 'has_cuci');
define('HAS_RETUR', 'has_retur');
define('HAS_REWASH', 'has_rewash');
define('HAS_USER', 'has_user');
define('HAS_VIEW', 'has_view');
define('HAS_LOG', 'has_log');

define('UPLOAD', 'upload');
define('KEY', 'key');
define('RFID', 'rfid');
define('RS_ID', 'rs_id');
define('BAHAN_ID', 'bahan_id');
define('SUPPLIER_ID', 'supplier_id');
define('RUANGAN_ID', 'ruangan_id');
define('JENIS_ID', 'jenis_id');
define('STATUS_CUCI', 'status_cuci');
define('STATUS_REGISTER', 'status_register');
define('STATUS_TRANSAKSI', 'status_transaksi');
define('STATUS_PROCESS', 'status_process');
define('STATUS_SYNC', 'status_sync');
define('TANGGAL_UPDATE', 'tanggal_update');

define('KOTOR', [TransactionType::KOTOR, TransactionType::REJECT, TransactionType::REWASH]);
define('BERSIH', [TransactionType::BERSIH]);

function module($module = null)
{
    return SharedData::get($module);
}

function moduleCode($name = null)
{
    return ! empty($name) ? $name : SharedData::get('module_code');
}

function moduleName($name = null)
{
    return ! empty($name) ? __($name) : __(SharedData::get('menu_name'));
}

function moduleAction($name = null)
{
    return moduleCode().'.'.$name;
}

function moduleRoute($action, $param = false)
{
    return $param ? route(moduleAction($action), $param) : route(moduleAction($action));
}

function modulePath($name = null)
{
    return ! empty($name) ? $name : moduleCode($name);
}

function modulePathTable($name = null)
{
    if ($name) {
        return 'pages.'.$name.'.table';
    }

    return 'pages.'.moduleCode().'.table';
}

function modulePathPrint($name = null)
{
    if ($name) {
        return 'pages.'.moduleCode().'.'.$name;
    }

    return 'pages.master.print';
}

function modulePathForm($name = null, $template = null)
{
    if ($template && $name) {
        return 'pages.'.$template.'.'.$name;
    }

    if ($name) {
        return 'pages.'.moduleCode().'.'.$name;
    }

    if ($template) {
        return 'pages.'.$template.'.form';
    }

    return 'pages.'.moduleCode().'.form';
}

function moduleView($template, $data = [])
{
    $view = view($template)->with($data);
    if (request()->header('hx-request') && env('APP_SPA', false)) {
        $view = $view->fragment('content');
    }

    return $view;
}

function formatLabel($value)
{

    $label = Str::of($value);
    if ($label->contains('_')) {
        $label = $label = $label->explode('_')->last();
    } else {
        $label = $label->replace('[]', '');
    }

    return ucfirst($label);
}

function formatAttribute($value)
{

    $label = Str::of($value);
    if ($label->contains(' ')) {
        $label = $label = $label->explode(' ')->last();
    } else {
        $label = $label->replace('[]', '');
    }

    return ucfirst($label);
}

function formatWorld($value)
{
    if (! empty($value)) {
        return Str::title(str_replace('_', ' ', Str::snake($value))) ?? 'Unknow';
    }
}

function formatCapitilizeSentance($value)
{
    if (! empty($value)) {
        return str_replace('_', ' ', $value) ?? 'Unknow';
    }
}

function showValue($value)
{
    if ($value == 0) {
        return '';
    }

    return $value;
}

function role($role)
{
    return auth()->check() && auth()->user()->role == $role;
}

function level($value)
{
    return auth()->check() && auth()->user()->level >= $value;
}

function imageUrl($value, $folder = null)
{
    $path = $folder ? $folder : moduleCode();

    return asset('public/storage/'.$path.'/'.$value);
}

function formatDateMySql($value, $datetime = false)
{

    if ($datetime === false) {
        $format = 'Y-m-d';
    } elseif ($datetime === true) {
        $format = 'Y-m-d H:i:s';
    } else {
        $format = $datetime;
    }

    if ($value instanceof Carbon) {
        $value = $value->format($format);
    } elseif (is_string($value)) {
        $value = SupportCarbon::parse($value)->format($format);
    }

    return $value ?: null;
}

function formatDate($value, $datetime = false)
{

    if ($datetime === false) {
        $format = 'd/m/Y';
    } elseif ($datetime === true) {
        $format = 'd/m/Y H:i:s';
    } else {
        $format = $datetime;
    }

    if (empty($value)) {
        return null;
    }

    if ($value instanceof Carbon) {
        $value = $value->format($format);
    } elseif (is_string($value)) {
        $value = SupportCarbon::parse($value)->format($format);
    }

    return $value ?: null;
}

function formatRupiah($value)
{
    return !empty($value) ? number_format($value, 0, ',', '.') : '0';
}

function iteration($model, $key)
{
    return $model->firstItem() + $key;
}

function checkActive($rsid)
{
    if (env('TRANSACTION_ACTIVE_RS_ONLY', 1) && ! (Rs::find($rsid)->field_active)) {
        return Notes::error($rsid, 'Rs belum di registrasi');
    }
}

function unic($length)
{
    $chars = array_merge(range('a', 'z'), range('A', 'Z'));
    $length = intval($length) > 0 ? intval($length) : 16;
    $max = count($chars) - 1;
    $str = '';

    while ($length--) {
        shuffle($chars);
        $rand = mt_rand(0, $max);
        $str .= $chars[$rand];
    }

    return $str;
}

function getClass($class)
{
    return (new \ReflectionClass($class))->getShortName();
}

function getLowerClass($class)
{
    return strtolower(getClass($class));
}

function setString($value)
{
    return '"'.$value.'"';
}

function getLogoUrl()
{
    $logo = Rs::find(auth()->user()->rs_id)->field_logo ?? null;

    if ($logo) {
        return url('storage/logo/'.$logo);
    }

    if (env('APP_LOGO')) {
        return url('storage/'.env('APP_LOGO'));
    }

    return url('assets/media/image/logo.png');
}
