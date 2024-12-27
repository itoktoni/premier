<?php

namespace App\Http\Services;

use App\Dao\Interfaces\CrudInterface;
use Plugins\Alert;
use Plugins\Notes;

class SingleService
{
    public function get(CrudInterface $repository, $code, $relation = false)
    {
        if (request()->wantsJson()) {
            return Notes::single($repository->singleRepository($code, $relation));
        }

        return $repository->singleRepository($code, $relation);
    }

    public function delete(CrudInterface $repository, $code)
    {
        $rules = ['code' => 'required'];
        request()->validate($rules, ['code.required' => 'Silahkan centang terlebih dahulu!']);

        $check = $repository->deleteRepository($code);
        if ($check['status']) {
            Alert::delete();
        } else {
            Alert::error($check['message']);
        }

        if (request()->wantsJson()) {
            return response()->json($check)->getData();
        }

        return $check;
    }

    public function sort($repository, $data)
    {
        $check = false;
        $model = $repository->model ?? false;
        if ($data && $model) {
            foreach ($data as $key => $value) {
                $check = $model::find($key)->update([$model->field_sort() => $value]);
            }
        }

        $check = Notes::update($data);
        Alert::update();

        return $check;
    }
}
