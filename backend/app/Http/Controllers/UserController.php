<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DeleteRequest;
use App\Http\Requests\User\StoreUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $perPage = (int)request()->per_page ?? null;
        $collection = $perPage > 0 ? User::paginate($perPage) : User::all();

        return response()->json($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreUpdateRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUpdateRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $password = $validatedData['password'];
        $departments = $validatedData['departments'] ?? null;

        $user = new User($validatedData);
        $user->password = $password;
        $user->save();

        if ($departments) {
            $user->departments()->sync($departments);
            $user->refresh();
        }

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @return JsonResponse
     */
    public function show(int $userId): JsonResponse
    {
        return response()->json(
            User::with('departments')->findOrFail($userId)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\User\StoreUpdateRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(StoreUpdateRequest $request, User $user): JsonResponse
    {
        $validatedData = $request->validated();
        $password = $validatedData['password'] ?? null;

        if ($password) $user->password = $password;

        $user->fill($validatedData)->save();

        $user->departments()->sync($validatedData['departments'] ?? []);
        $user->refresh();


        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request, User $user): JsonResponse
    {
        return response()->json($user->delete());
    }
}
