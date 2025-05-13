<?php
namespace App\Contracts;

interface PatientServiceInterface
{
    public function getAllPatients();
    public function getPatientById(int $id);
    public function updatePatient(int $id, array $data);
    public function createPatient(array $data);
    public function deletePatient(int $id);
}