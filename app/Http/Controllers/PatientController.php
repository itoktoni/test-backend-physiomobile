<?php

namespace App\Http\Controllers;

use App\Contracts\PatientServiceInterface;
use App\Helpers\ApiResponse;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @group Patient Management
 *
 * APIs for managing patients
 * please use key: "API_ACCESS_KEY"
 * edit in .env file
 */
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
    /**
     * List all patients
     *
     * Get a list of all patients in the system.
     *
     * @response 200 {
     *  "data": [
     *    {
     *      "id": 1,
     *      "name": "John Doe",
     *      "address": "123 Main St",
     *      "id_type": "identity_card",
     *      "id_no": "1234567890",
     *      "gender": "male",
     *      "dob": "1990-08-15",
     *      "medium_acquisition": "walk_in",
     *      "created_at": "2024-05-13T10:00:00.000000Z",
     *      "updated_at": "2024-05-13T10:00:00.000000Z"
     *    }
     *  ]
     * }
     *
     * @authenticated
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
    /**
     * Create a new patient
     *
     * @bodyParam name string required Patient's full name
     * @bodyParam address string required Patient's complete address
     * @bodyParam id_type string required Type of ID (identity_card, passport)
     * @bodyParam id_no string required ID number
     * @bodyParam gender string required Patient's gender (male/female)
     * @bodyParam dob date required Date of birth (YYYY-MM-DD)
     * @bodyParam medium_acquisition string required How patient was acquired (walk_in, referral)
     *
     * @response 201 {
     *  "data": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "address": "123 Main St",
     *    "id_type": "identity_card",
     *    "id_no": "1234567890",
     *    "gender": "male",
     *    "dob": "1990-08-15",
     *    "medium_acquisition": "walk_in",
     *    "created_at": "2024-05-13T10:00:00.000000Z",
     *    "updated_at": "2024-05-13T10:00:00.000000Z"
     *  }
     * }
     *
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *    "name": ["The name field is required."],
     *    "id_type": ["The id type field is required."]
     *  }
     * }
     *
     * @authenticated
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
    /**
     * Get a specific patient
     *
     * @urlParam id integer required The ID of the patient
     *
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "address": "123 Main St",
     *    "id_type": "identity_card",
     *    "id_no": "1234567890",
     *    "gender": "male",
     *    "dob": "1990-08-15",
     *    "medium_acquisition": "walk_in",
     *    "created_at": "2024-05-13T10:00:00.000000Z",
     *    "updated_at": "2024-05-13T10:00:00.000000Z"
     *  }
     * }
     *
     * @authenticated
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
    /**
     * Update a patient
     *
     * @urlParam id integer required The ID of the patient
     * @bodyParam name string Patient's full name
     * @bodyParam address string Patient's complete address
     * @bodyParam id_type string Type of ID (identity_card, passport)
     * @bodyParam id_no string ID number
     * @bodyParam gender string Patient's gender (male/female)
     * @bodyParam dob date Date of birth (YYYY-MM-DD)
     * @bodyParam medium_acquisition string How patient was acquired (walk_in, referral)
     *
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "name": "John Doe Updated",
     *    "address": "456 New St",
     *    "id_type": "identity_card",
     *    "id_no": "1234567890",
     *    "gender": "male",
     *    "dob": "1990-08-15",
     *    "medium_acquisition": "walk_in",
     *    "created_at": "2024-05-13T10:00:00.000000Z",
     *    "updated_at": "2024-05-13T10:00:00.000000Z"
     *  }
     * }
     *
     * @authenticated
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
    /**
     * Delete a patient
     *
     * @urlParam id integer required The ID of the patient
     *
     * @response 200 {
     *  "message": "Patient deleted successfully"
     * }
     *
     * @authenticated
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
