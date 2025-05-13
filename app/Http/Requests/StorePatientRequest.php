<?php

namespace App\Http\Requests;

use App\GenderEnum;
use App\IdTypeEnum;
use App\MediumAcquisitionEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'id_type' => ['required', new Enum(IdTypeEnum::class)],
            'id_no' => 'required|string|max:100|unique:patients,id_no',
            'gender' =>  ['required', new Enum(GenderEnum::class)],
            'dob' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'medium_acquisition' => ['required', new Enum(MediumAcquisitionEnum::class)],
        ];
    }

    public function withValidator($validator)
    {
        $name = $this->input('name');
        $dob = $this->input('dob');
        $gender = $this->input('gender');

        $userExist = User::where('name', $name)
            ->where('dob', $dob)
            ->where('gender', $gender)
            ->exists();

        $validator->after(function ($validator) use ($userExist) {
            if ($userExist) {
                $validator->errors()->add('name', 'User already exists');
            }
        });
    }
}
