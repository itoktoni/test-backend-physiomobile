<?php

namespace App;

enum GenderEnum : string
{
    case Male = 'male';
    case Female = 'female';

    public function label(): string {
        return match($this) {
            GenderEnum::Male => 'Male',
            GenderEnum::Female => 'Female',
        };
    }
}
