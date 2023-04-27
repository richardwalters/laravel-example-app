<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $user_service)
    {
        $this->userService = $user_service;
    }

    #[OA\Get(
        path: '/api/users',
        responses: [
            new OA\Response(
                response: '200',
                description: 'A single user tree.',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            'users',
                            type: 'array',
                            items: new OA\Items(
                                ref: '#/components/schemas/User'
                            )
                        ),
                    ],
                    type: 'object'
                )
            ),
        ]
    )]
    public function index()
    {
        return UserResource::collection($this->userService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
