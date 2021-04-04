<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreUpdateRequest;
use App\Models\Department;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $perPage = (int)request()->per_page ?? null;
        $collection = $perPage > 0 ? Department::paginate($perPage) : Department::all();

        return response()->json($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Department\StoreUpdateRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUpdateRequest $request): JsonResponse
    {
        return response()->json(Department::create($request->validated()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Department  $department
     * @return JsonResponse
     */
    public function show(Department $department): JsonResponse
    {
        return response()->json($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Department\StoreUpdateRequest  $request
     * @param  Department  $department
     * @return JsonResponse
     */
    public function update(StoreUpdateRequest $request, Department $department): JsonResponse
    {
        $department->update($request->validated());

        return response()->json($department);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Department  $department
     * @return JsonResponse
     */
    public function destroy(Department $department): JsonResponse
    {
        return response()->json($department->delete());
    }
}
