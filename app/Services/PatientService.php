<?php
namespace App\Services;

use App\Contracts\PatientRepositoryInterface;
use App\Contracts\PatientServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Resources\PatientResource;

class PatientService implements PatientServiceInterface
{
    protected $repository;

    public function __construct(PatientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllPatients()
    {
        return PatientResource::collection($this->repository->all());
    }

    public function getPatientById(int $id)
    {
        $patient = $this->repository->find($id);
        return new PatientResource($patient);
    }

    public function createPatient(array $data)
    {
        $patient = $this->repository->create($data);
        return new PatientResource($patient);
    }

    public function updatePatient(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deletePatient(int $id)
    {
        try
        {
            $patient = $this->repository->delete($id);
            return new PatientResource($patient);
        }
        catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
}