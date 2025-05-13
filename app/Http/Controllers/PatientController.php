<?php

namespace App\Http\Controllers;

use App\Contracts\PatientServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientServiceInterface $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = $this->patientService->getAllPatients();
        return ApiResponse::success(
            data: $patients,
            message: 'Patients retrieved successfully',
            status: 200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request): JsonResponse
    {
        dd($request->all());
        try {
            $data = $this->patientService->createPatient($request->validated());
            return ApiResponse::success(
                data: $data,
                message: 'Patient created successfully',
                status: 201
            );
        } catch (ValidationException $e) {
            return ApiResponse::error(
                message: 'Validation failed',
                errors: $e->errors(),
                status: 422
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to create patient',
                errors: [$e->getMessage()],
                status: 500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $data = $this->patientService->getPatientById($id);
            return ApiResponse::success(
                data: $data,
                message: 'Patient created successfully',
                status: 201
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to create patient',
                errors: [$e->getMessage()],
                status: 500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, int $id)
    {
        try {
            $data = $this->patientService->updatePatient($id, $request->validated());
            return ApiResponse::success(
                data: $data,
                message: 'Patient updated successfully',
                status: 201
            );
        } catch (ValidationException $e) {
            return ApiResponse::error(
                message: 'Validation failed',
                errors: $e->errors(),
                status: 422
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to updated patient',
                errors: [$e->getMessage()],
                status: 500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $data = $this->patientService->deletePatient($id);
            return ApiResponse::success(
                data: $data,
                message: 'Patient deleted successfully',
                status: 201
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                message: 'Failed to deleted patient',
                errors: [$e->getMessage()],
                status: 500
            );
        }
    }
}
