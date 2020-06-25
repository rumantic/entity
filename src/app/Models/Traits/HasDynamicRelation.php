<?php
namespace Sitebill\Entity\app\Models\Traits;

use Sitebill\Entity\app\Models\Meta\EntityItem;

trait HasDynamicRelation
{
    /**
     * Store the relations
     *
     * @var array
     */
    private static $dynamic_relations = [];
    private static $entity_storage = [];

    /**
     * Add a new relation
     *
     * @param $name
     * @param EntityItem $entity_item
     * @param $closure
     */
    public static function addDynamicRelation($name, EntityItem $entity_item, $closure)
    {
        static::$dynamic_relations[$name] = $closure;
        static::$entity_storage[$name] = $entity_item;
    }

    /**
     * Determine if a relation exists in dynamic relationships list
     *
     * @param $name
     *
     * @return bool
     */
    public static function hasDynamicRelation($name)
    {
        return array_key_exists($name, static::$dynamic_relations);
    }

    /**
     * If the key exists in relations then
     * return call to relation or else
     * return the call to the parent
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (static::hasDynamicRelation($name)) {
            // check the cache first
            if ($this->relationLoaded($name)) {
                return $this->relations[$name];
            }

            // load the relationship
            return $this->getRelationshipFromMethod($name);
        }

        return parent::__get($name);
    }

    /**
     * If the method exists in relations then
     * return the relation or else
     * return the call to the parent
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (static::hasDynamicRelation($name)) {
            return call_user_func(static::$dynamic_relations[$name], $this, static::$entity_storage[$name]);
        }

        return parent::__call($name, $arguments);
    }
}
