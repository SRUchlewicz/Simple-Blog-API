<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\User;
use App\Exceptions\UserNotFoundException;
use Illuminate\Support\Facades\Hash;

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
        return $this->userRepository->create([
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
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

    /**
     * @throws UserNotFoundException
     */
    public function changeUserPassword(string $email, string $newPass): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw new UserNotFoundException("User with email {$email} not found");
        }

        $this->userRepository->update($user, ['password' => Hash::make($newPass)]);
    }
}
