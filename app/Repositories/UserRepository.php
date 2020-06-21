<?php
/**
 * Created by PhpStorm.
 * User: Stamen
 * Date: 6/21/2020
 * Time: 10:31 AM
 */

namespace App\Repositories;


use App\Factory\CacheFactory;
use App\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var CacheFactory
     */
    private $cacheFactory;

    protected static $_userKey = "user::";
    protected static $_getAllUsersKey = "user::all";

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->cacheFactory = CacheFactory::create();
    }

    /**
     * Find User by ID
     *
     * @param int $id
     * @return User
     */
    public function find(int $id): User
    {
        $key = self::$_userKey . $id;

        $user = $this->cacheFactory->retrieve($key);
        if($user === null) {

            $user = User::find($id);

            $this->cacheFactory->store($key, $user);
        }

        return $user;
    }

    /**
     * Return all Users
     *
     * @return mixed
     */
    public function all(): Collection
    {
        $users = $this->cacheFactory->retrieve(self::$_getAllUsersKey);
        if($users === null) {

            $users = User::all();

            $this->cacheFactory->store(self::$_getAllUsersKey, $users);
        }

        return $users;
    }

    /**
     * Create new User
     *
     * @param array $user
     * @return User
     */
    public function create(array $user): User
    {
        try {
            $user = User::create($user);

            $this->cacheFactory->eliminate(self::$_getAllUsersKey);

            return $user;
        }

        catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Update User
     *
     * @param int $id
     * @param array $data
     * @return User
     */
    public function update(int $id, array $data): bool
    {
        try {

            $key = self::$_userKey . $id;

            User::where('id', $id)
                ->update($data);

            $this->cacheFactory->eliminate(self::$_getAllUsersKey);
            $this->cacheFactory->eliminate($key);

            return true;
        }

        catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * Delete User
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        try {

            $key = self::$_userKey . $user->id;

            $user->delete();

            $this->cacheFactory->eliminate(self::$_getAllUsersKey);
            $this->cacheFactory->eliminate($key);

            return true;
        }

        catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
}