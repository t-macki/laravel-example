<?php
namespace Infra\Repositories\Eloquents;

use Carbon\Carbon;
use Domain\Interfaces\Repositories\UserRepository;
use Infra\Eloquents\User;

class EloquentUserRepository extends BaseRepository implements UserRepository
{
    public function __construct(User $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @param $field
     * @param $value
     * @param array $columns
     */
    public function first($field, $value, $columns = ['*'])
    {
        return $this->eloquent->where($field, '=', $value)->first($columns);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        return $this->eloquent->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return User
     */
    public function update(array $data, $id)
    {
        $model = $this->find($id);
        if ($model) {
            if ($model->update($data)) {
                return $this->find($id);
            }
        }
        return new User();
    }

    public function verifyDone($id)
    {
        $user = $this->find($id);
        $user->email_verify_time = Carbon::now();
        $user->email_verify_sent_at = null;
        $user->email_verify_status = \Config::get('const.USER_VERIFY_STATUS_OK');
        $user->status = \Config::get('const.USER_STATUS_REGIST');
        $user->email = $user->email_temp;
        $user->email_temp = '';

        $user->save();
        return $user;
    }
}