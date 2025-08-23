@php
$action = request()->get('action');
$height = '100px';
if($action == 'excel'){
    $height = '15%';
}
@endphp
<img style="position: absolute;left:40%;top:-10px;" src="{{ getLogoUrl() }}" alt="logo">