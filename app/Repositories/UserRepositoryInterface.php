<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 10:32 AM
 */

namespace App\Repositories;


use App\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Find User by ID
     *
     * @param int $id
     * @return User
     */
    public function find(int $id) : User;

    /**
     * Return all Users
     *
     * @return mixed
     */
    public function all() : Collection;

    /**
     * Create new User
     *
     * @param array $user
     * @return User
     */
    public function create(array $user) : User;

    /**
     * Update User
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data) : bool;

    /**
     * Delete User
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user) : bool;
}