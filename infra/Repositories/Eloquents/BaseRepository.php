<?php
namespace Infra\Repositories\Eloquents;

class BaseRepository
{
    protected $eloquent;

    /**
     * 登録
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->eloquent->create($data);
    }

    /**
     * 更新
     * @param array $data
     * @param $id
     * @return null
     */
    public function update(array $data, $id)
    {
        $model = $this->find($id);
        if ($model) {
            if ($model->update($data)) {
                return $this->find($id);
            }
        }
        return null;
    }

    /**
     * 削除（物理削除）
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $model = $this->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    /**
     * キーと値で検索して削除
     * @param $field
     * @param $value
     */
    public function findDelete($field, $value)
    {
        $data = $this->findByField($field, $value, ['id' => 'asc']);
        if ($data && !$data->isEmpty()) {
            $this->eloquent->where($field, '=', $value)->delete();
        }
    }

    /**
     * ID指定で1件取得
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        return $this->eloquent->find($id, $columns);
    }

    /**
     * ID指定で1件取得(soft deleteも取得対象)
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findwithTrashed($id, $columns = ['*'])
    {
        return $this->eloquent->withTrashed()->find($id, $columns);
    }

    /**
     * カラム指定で1件取得
     * @param $field
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function first($field, $value, $columns = ['*'])
    {
        return $this->eloquent->where($field, '=', $value)->first($columns);
    }

    /**
     * 条件1つで複数件取得
     * @param $field
     * @param $value
     * @param array $orderby
     * @param array $columns
     * @return mixed
     */
    public function findByField($field, $value, array $orderby, $columns = ['*'])
    {
        $query = $this->eloquent->query();
        $query = $this->applyOrderBy($query, $orderby);
        return $query->where($field, '=', $value)->get($columns);
    }

    /**
     * リスト
     * @param $value
     * @param $key
     * @param array $orderby
     * @param array $where
     * @return mixed
     */
    public function lists($value, $key, array $orderby, $where = [])
    {
        $query = $this->eloquent->query();
        $query = $this->applyOrderBy($query, $orderby);
        $query = $this->applyConditions($query, $where);
        return $query->pluck($value, $key);
    }

    /**
     * 複数件取得
     * @param array $orderby
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $orderby, array $where, $columns = ['*'])
    {
        $query = $this->eloquent->query();
        $query = $this->applyConditions($query, $where);
        $query = $this->applyOrderBy($query, $orderby);
        return $query->get($columns);
    }

    public function findWhereFirst(array $orderby, array $where, $columns = ['*'])
    {
        $query = $this->eloquent->query();
        $query = $this->applyConditions($query, $where);
        $query = $this->applyOrderBy($query, $orderby);
        return $query->first($columns);
    }

    protected function orderBy($query, $column, $direction = 'asc')
    {
        return $query->orderBy($column, $direction);
    }

    protected function applyOrderBy($query, $orderby = [])
    {
        if ($orderby) {
            foreach ($orderby as $column => $direction) {
                $query = $this->orderBy($query, $column, $direction);
            }
        }
        return $query;
    }

    protected function applyConditions($query, $where = [])
    {
        if ($where) {
            foreach ($where as $field => $value) {
                if (is_array($value)) {
                    list($field, $condition, $val) = $value;
                    $query = $query->where($field, $condition, $val);
                } else {
                    $query = $query->where($field, '=', $value);
                }
            }
        }
        return $query;
    }
}
