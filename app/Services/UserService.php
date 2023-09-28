<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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

    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function getUsersByPage(?int $page = 1): LengthAwarePaginator
    {
        return $this->userRepository->getPaginated($page, getDefaultPerPage());
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getUserById(int $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function createUser(array $data): User
    {
        return $this->userRepository->create([
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => isset($data['role_id']) ? $data['role_id'] : $this->roleRepository->getDefaultRoleId()
        ]);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function updateUser(int $id, array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']); // TODO make some function that will prepare data instead of this
        }
        
        return $this->userRepository->update($id, $data);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function deleteUser(int $id): void
    {
        $this->userRepository->delete($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function changeUserPassword(string $email, string $newPass): void
    {
        $user = $this->userRepository->getByEmail($email);
        $this->userRepository->update($user->id, ['password' => Hash::make($newPass)]);
    }
}
