<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->all();

        return response()->json($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        try {
            $user = $this->userRepository->create([
                'email'         => $request->email,
                'password'      => Hash::make($request->password),
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'date_of_birth' => $request->date_of_birth,
                'address'       => $request->address,
            ]);

            return response()->json($user);
        }

        catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userRepository->find($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $this->userRepository->update($user->id, $request->only('first_name', 'last_name', 'date_of_birth', 'address'));

            return response()->json(['message' => "User is updated"]);
        }

        catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }

    /**
     * Delete specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $this->userRepository->delete($user);

            return response()->json(['message' => "User is deleted"]);
        }
        catch (\Exception $exception) {
            return response($exception->getMessage(), 500);
        }
    }
}
