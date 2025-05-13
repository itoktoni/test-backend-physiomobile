<?php

namespace App\Models;

use App\MediumAcquisitionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'medium_acquisition',
    ];

    protected $casts = [
        'medium_acquisition' => MediumAcquisitionEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
