<?php

namespace App;

use App\Attributes\EnumAttributes;

enum MediumAcquisitionEnum : string
{
    case Referral = 'referal';
    case OnlineForm = 'online_form';
    case WalkIn = 'walk_in';

    public function label(): string {
        return match($this) {
            MediumAcquisitionEnum::Referral => 'Referral',
            MediumAcquisitionEnum::OnlineForm => 'Online Form',
            MediumAcquisitionEnum::WalkIn => 'Walk In',
        };
    }
}
