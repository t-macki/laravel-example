<?php
namespace Infra\Repositories\Eloquents;

use Domain\Interfaces\Repositories\ContactRepository;
use Infra\Eloquents\Contact;

class EloquentContactRepository extends BaseRepository implements ContactRepository
{
    public function __construct(Contact $eloquent)
    {
        $this->eloquent = $eloquent;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        return $this->eloquent->create($data);
    }
}
