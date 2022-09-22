<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Resources\UserItemResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $userService;

    public function __construct( UserService $userService )
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $items = User::query()->search()->latest()->paginate()->withQueryString();

        return UserResource::collection( $items );
//            ->additional( [ 'meta' => $data ] );
    }

    public function store( UserRequest $request )
    {
        $item = $this->userService->create( $request->validated() );

        return new UserItemResource( $item );
    }

    public function show( $user )
    {
        return new UserItemResource( User::FindOrFail( $user ) );
    }

    public function update( UserRequest $request, $user )
    {
        $item = $this->userService->update( $user, $request->validated() );

        return new UserResource( ( $item ) );
    }

    public function destroy( $user )
    {
        $this->userService->destroy( $user );

        return response()->json( [], Response::HTTP_NO_CONTENT );
    }
}
