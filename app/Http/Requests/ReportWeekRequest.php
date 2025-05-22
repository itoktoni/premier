<?php

namespace App\Http\Requests;

use App\Dao\Traits\ValidationTrait;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReportWeekRequest extends FormRequest
{
    use ValidationTrait;

    public function validation(): array
    {
        return [
            'start_rekap' => 'required',
            'end_rekap' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $startDate = $this->get('start_rekap');
        $endDate = $this->get('end_rekap');

        $diff = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));

        $validator->after(function ($validator) use ($diff) {

            if($diff > 7){

                $validator->errors()->add('end_rekap', 'Penarikan report tidak boleh melebihi 7 hari !');
            }

        });
    }
}
