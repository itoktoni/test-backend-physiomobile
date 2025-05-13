<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'gender' => $this->user->gender,
            'dob' => $this->user->dob,
            'address' => $this->user->address,
            'medium_acquisition' => $this->medium_acquisition,
        ];
    }
}
