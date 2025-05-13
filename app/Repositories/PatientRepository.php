<?php
namespace App\Repositories;

use App\Contracts\PatientRepositoryInterface;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class PatientRepository implements PatientRepositoryInterface
{
    public function all()
    {
        return Patient::with('user')->get();
    }

    public function find(int $id)
    {
        return Patient::findOrFail($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'gender' => $data['gender'],
                'dob' => $data['dob'],
                'id_no' => $data['id_no'],
                'id_type' => $data['id_type'],
                'address' => $data['address'],
            ]);

            $patient = Patient::create([
                'user_id' => $user->id,
                'medium_acquisition' => $data['medium_acquisition']
            ]);

            return $patient;
        });
    }

    public function update(int $id, array $data)
    {
        return Patient::find($id)->update($data);
    }

    public function delete(int $id)
    {
        $patient = Patient::findOrFail($id);
        if($patient)
        {
            DB::transaction(function () use ($patient) {
                $patient->user->delete();
                $patient->delete();
            });

            return $patient;
        }
        else
        {
            return false;
        }
    }
}