<?php

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Contracts\UserRepositoryInterface;
use App\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Exceptions\UserNotFoundException;

class UserService implements UserServiceInterface
{
    private $userRepository;
    private $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function register(array $data): User
    {
        $validator = Validator::make($data, [
            'firstname' => 'required|string|between:3,15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->userRepository->create([
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $this->roleRepository->getDefaultRoleId()
        ]);
    }

    /**
     * @throws UserNotFoundException
     */
    public function update(int $id, array $data): ?User
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new UserNotFoundException("User with ID {$id} not found");
        }

        return $this->userRepository->update($user, $data);
    }

    /**
     * @throws UserNotFoundException
     */
    public function delete(int $id): void
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new UserNotFoundException("User with ID {$id} not found");
        }

        $this->userRepository->delete($user);
    }
}
