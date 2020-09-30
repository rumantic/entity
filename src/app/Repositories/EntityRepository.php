<?php
namespace Sitebill\Entity\app\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;
use Sitebill\Realty\app\Models\Topic;

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

    public function join_select ($slug = '', $perPage = 6) {
        $query = $this->init_join_query();
        $topic_id = $this->get_topic_id_from_slug($slug);
        if ( $topic_id ) {
            $query->where($this->model->getTable().'.'.'topic_id', $topic_id);
        }

        return $query->paginate($perPage);
    }

    protected function get_topic_id_from_slug($slug) {
        $topic = Topic::where('url', $slug)->first();
        if ( $topic ) {
            return $topic->id;
        }
        return false;
    }


    public function join_select_by_id($id) {
        $query = $this->init_join_query();
        $query->where($this->model->getTable().'.'.$this->model->getKeyName(), $id);
        return $query->firstOr();
    }


}
