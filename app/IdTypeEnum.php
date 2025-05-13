<?php

namespace App;

enum IdTypeEnum : string
{
    case IdentityCard = 'identity_card';
    case DrivingLicence = 'driving_licence';
    case Pasport = 'pasport';
    case Other = 'other';

    public function label(): string {
        return match($this) {
            IdTypeEnum::IdentityCard => 'Identity Card',
            IdTypeEnum::DrivingLicence => 'Driving Licence',
            IdTypeEnum::Pasport => 'Pasport',
            IdTypeEnum::Other => 'Other',
        };
    }
}
