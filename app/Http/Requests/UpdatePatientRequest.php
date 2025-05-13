<?php

namespace App\Http\Requests;

use App\GenderEnum;
use App\IdTypeEnum;
use App\MediumAcquisitionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'id_type' => ['required', new Enum(IdTypeEnum::class)],
            'id_no' => 'sometimes|string|max:100|unique:patients,id_no,' . $this->patient,
            'gender' =>  ['required', new Enum(GenderEnum::class)],
            'dob' => 'sometimes|date',
            'address' => 'sometimes|string',
            'medium_acquisition' => ['required', new Enum(MediumAcquisitionEnum::class)],
        ];
    }
}