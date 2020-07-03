<?php
namespace Sitebill\Entity\app\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

abstract class EntityRepository extends BaseRepository {
    use CacheableRepository;

    protected function init_join_query () {
        $this->makeModel();
        $joins = $this->model->prepareJoins();

        $query = $this->model->newQuery();
        $selects[] = $this->model->getTable().'.*';

        if ( !empty($joins) ) {
            foreach ($joins as $join) {
                $query->leftJoin($join['table'], $join['first'], $join['operator'], $join['second']);
                $selects[] = $join['select'];
            }
        }
        $query->select($selects);
        return $query;
    }

    public function join_select ($perPage = 5) {
        $query = $this->init_join_query();

        return $query->paginate($perPage);
    }

    public function join_select_by_id($id) {
        $query = $this->init_join_query();
        $query->where($this->model->getTable().'.'.$this->model->getKeyName(), $id);
        return $query->firstOr();
    }


}
