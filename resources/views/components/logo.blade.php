@php
$action = request()->get('action');
$height = '100px';
if($action == 'excel'){
    $height = '15%';
}

$rs_logo = Rs::find(auth()->user()->rs_id)->field_logo ?? null;

$path = env('APP_LOGO') ? url('storage/'.env('APP_LOGO')) : url('assets/media/image/logo.png');
if(!empty($rs_logo)) {
    $path = $rs_logo;
}

@endphp
<img style="position: absolute;left:40%;top:5px;" src="{{ $path }}" alt="logo">