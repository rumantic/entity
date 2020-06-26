<?php
namespace Sitebill\Entity\app\Models\Traits;

use Illuminate\Support\Facades\DB;
use Sitebill\Entity\app\Models\Config;
use Sitebill\Entity\app\Models\Meta\EntityItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Sitebill\Realty\app\Models\currency;

trait Meta {
    use HasDynamicRelation;

    /**
     * @var mixed
     */
    private static $model_storage;

    /**
     * @var mixed
     */
    private static $model_cache;

    private $activity_and_group;

    protected $meta_loaded = false;

    public function get_entity($column_name): ?EntityItem {
        Log::info('column_name = '.$column_name);
        $result = array();
        $table_name_with_group_and_activity = $this->getTable().$this->get_group_and_activity();
        $table_name = $this->getTable();
        if ( !empty(self::$model_storage[$table_name_with_group_and_activity][$table_name][$column_name]) ) {
            $result = self::$model_storage[$table_name_with_group_and_activity][$table_name][$column_name];
            $entity = new EntityItem($result);
        } else {
            $entity = new EntityItem(null);
            //throw (new \Exception('column = '.$column_name.' in table = '.$table_name.' not defined'));
        }

        return $entity;
    }

    public function get_all_columns () {
        if ( !$this->is_meta_loaded() ) {
            $this->load_sitebill();
        }
        //Log::info('get_all_columns');

        $table_name_with_group_and_activity = $this->getTable().$this->get_group_and_activity();
        $table_name = $this->getTable();
        if ( !empty(self::$model_storage[$table_name_with_group_and_activity][$table_name]) ) {
            $columns = self::$model_storage[$table_name_with_group_and_activity][$table_name];
            $result = collect();
            foreach ( $columns as $column_name => $column_item ) {
                $entity_item = new EntityItem($column_item);
                if ( $entity_item->type() == 'select_by_query' ) {
                    self::addDynamicRelation($entity_item->name().'_rel', $entity_item, function($model, EntityItem $entity_item) {
                        //Log::info($entity_item->name().'_rel');
                        //Log::info($entity_item->primary_key_table());
                        //Log::info($entity_item->primary_key_name());

                        if ( !class_exists($entity_item->primary_key_table()) ) {
                            $aClass = 'class '.$entity_item->primary_key_table().' extends Illuminate\Database\Eloquent\Model {
                                    protected $table = \''.$entity_item->primary_key_table().'\';
                                    protected $primaryKey = \''.$entity_item->primary_key_name().'\';
                                } return '.$entity_item->primary_key_table().'::class;';
                            $class = eval($aClass);
                        } else {
                            $aClass = "return ".$entity_item->primary_key_table()."::class;";
                            $class = eval($aClass);
                        }
                        return $model->hasMany($class);
                    });
                }
                $result->put($column_name, $entity_item);
                //$fillable[] = $column_name;

            }
            return $result;
        }
        return null;
    }

    function unserializeSelectData($str) {
        $ret = array();
        $matches = array();
        preg_match_all('/\{[^\}]+\}/', $str, $matches);
        if (count($matches) > 0) {
            foreach ($matches[0] as $v) {
                $v = str_replace(array('{', '}'), '', $v);
                $d = explode('~~', $v);
                $ret[$d[0]] = $d[1];
            }
        }
        return $ret;
    }

    public function getPrimaryKeyName () {
        return $this->primaryKey;
    }
    function is_meta_loaded () {
        return $this->meta_loaded;
    }

    private function set_group_id ($ignore_user_group) {
        $group_id = 0;
        $anonimouse_group = intval(Config::getConfig('user_anonimouse_group_id'));
        if (isset($_SESSION['user_id_value']) && intval($_SESSION['user_id_value']) > 0) {
            $user_id = intval($_SESSION['user_id_value']);
        } elseif (isset($_SESSION['user_id']) && intval($_SESSION['user_id']) > 0) {
            $user_id = intval($_SESSION['user_id']);
        }

        if (!$ignore_user_group && isset($user_id)) {
            $group_id = $_SESSION['current_user_group_id'];
        } elseif (!$ignore_user_group && (!isset($user_id) || $user_id == 0)) {
            $group_id = $anonimouse_group;
        }
        $this->group_id = $group_id;
    }

    private function get_group_id () {
        return $this->group_id;
    }

    private function set_group_and_activity ($ignore_user_group, $ignore_activity) {
        $local_activity_and_group = '_' . ($ignore_user_group ? '1' : '0') . '_' . ($ignore_activity ? '1' : '0');
        $this->set_group_id($ignore_user_group);

        if ($this->get_group_id() != 0) {
            $local_activity_and_group .= '_' . $this->get_group_id();
        }
        $this->activity_and_group = $local_activity_and_group;
    }

    private function get_group_and_activity () {
        return $this->activity_and_group;
    }


    function load_sitebill($ignore_user_group = false, $ignore_activity = false) {
        $table_name = $this->getTable();
        Log::info('load_sitebill = '.$table_name);
        if ( empty($table_name) ) {
            throw (new \Exception('table_name not defined'));
        }

        $current_lang = config('app.locale');
        $this->set_group_and_activity($ignore_user_group, $ignore_activity);
        $model_name = $table_name.$this->get_group_and_activity();
        $group_id = $this->get_group_id();

        /**
         * TODO
         * Возможное дополнение метки модели в кеше признаком языка
         */
        //$model_name .= '_' . $current_lang;

        $input_model_name = $model_name;

        if (!isset(self::$model_storage[$model_name]) || empty(self::$model_storage[$model_name])) {
            $model_data = array();

            $db_prefix = config('database.connections.mysql.prefix');

            $query = "SELECT 
                        c.*, t.table_id, t.name as table_name 
                      FROM 
                           " . $db_prefix . "columns c, " . $db_prefix . "table t  
                      WHERE
                            t.table_id=c.table_id " . ($ignore_activity ? '' : ' AND active=1') . " 
                      ORDER BY c.table_id, c.sort_order";
            $row_models = DB::select($query);



            if (!$row_models) {
                $model_data[$table_name] = array();
                return $model_data;
            }
            foreach ($row_models as $ar_object) {
                $ar = (array)$ar_object;

                $table_name = $ar['table_name'];
                $model_name = $table_name.$this->get_group_and_activity();

                /**
                 * TODO
                 * Возможное дополнение метки модели в кеше признаком языка
                 */
                //$model_name .= '_' . $current_lang;
                if (!$ignore_user_group) {
                    if ($ar['type'] == 'captcha') {
                        if ($ar['group_id'] != '0' && $ar['group_id'] != '') {
                            $t = array();
                            $t = explode(',', $ar['group_id']);
                            //$t[]=0;
                            if ($group_id != 0 && !in_array($group_id, $t)) {
                                continue;
                            }
                        }
                    } else {
                        if ($ar['group_id'] != '0' && $ar['group_id'] != '') {
                            $t = array();
                            $t = explode(',', $ar['group_id']);
                            if (!in_array($group_id, $t)) {
                                continue;
                            }
                        }
                    }
                }

                $lang_prefix = config('app.locale');

                self::$model_storage[$model_name][$table_name][$ar['name']]['name'] = $ar['name'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['title'] = $ar['title'];
                if (!empty($ar['title' . $lang_prefix])) {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['title'] = $ar['title' . $lang_prefix];
                }

                if ( $ar['type'] == 'geodata' ) {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['value'] = array('lat' => '', 'lng' => '');
                } else {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['value'] = $ar['value'];
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['type'] = $ar['type'];

                self::$model_storage[$model_name][$table_name][$ar['name']]['primary_key_name'] = $ar['primary_key_name'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['primary_key_table'] = $ar['primary_key_table'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['value_string'] = $ar['value_string'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['query'] = $ar['query'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['value_name'] = $ar['value_name'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['title_default'] = $ar['title_default'];
                if (!empty($ar['title_default' . $lang_prefix])) {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['title_default'] = $ar['title_default' . $lang_prefix];
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['value_default'] = $ar['value_default'];

                self::$model_storage[$model_name][$table_name][$ar['name']]['value_table'] = $ar['value_table'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['value_primary_key'] = $ar['value_primary_key'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['value_field'] = $ar['value_field'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['assign_to'] = $ar['assign_to'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['dbtype'] = $ar['dbtype'];
                //self::$model_storage[$model_name][$table_name][$ar['name']]['select_data'] = ($ar['select_data']!='' ? unserialize($ar['select_data']) : array());
                if ($ar['select_data'] != '') {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['select_data'] = $this->unserializeSelectData($ar['select_data']);
                    if (!empty($ar['select_data' . $lang_prefix])) {
                        self::$model_storage[$model_name][$table_name][$ar['name']]['select_data'] = $this->unserializeSelectData($ar['select_data' . $lang_prefix]);
                    }
                    $select_data_indexed = array();
                    foreach ( self::$model_storage[$model_name][$table_name][$ar['name']]['select_data'] as $key_s => $value_s ) {
                        array_push($select_data_indexed, array('id'=>$key_s, 'value' => $value_s));
                    }
                    self::$model_storage[$model_name][$table_name][$ar['name']]['select_data_indexed'] = $select_data_indexed;
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['table_name'] = $ar['table_name'];
                if ((self::$model_storage[$model_name][$table_name][$ar['name']]['type'] == 'uploads' || self::$model_storage[$model_name][$table_name][$ar['name']]['type'] == 'docuploads') && self::$model_storage[$model_name][$table_name][$ar['name']]['table_name'] == '') {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['table_name'] = $table_name;
                } elseif (self::$model_storage[$model_name][$table_name][$ar['name']]['type'] == 'select_by_query' && self::$model_storage[$model_name][$table_name][$ar['name']]['table_name'] == '') {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['table_name'] = $table_name;
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['primary_key'] = $ar['primary_key'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['primary_key_value'] = $ar['primary_key_value'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['action'] = $ar['action'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['tab'] = $ar['tab'];
                if (!empty($ar['tab' . $lang_prefix])) {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['tab'] = $ar['tab' . $lang_prefix];
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['hint'] = $ar['hint'];
                if (!empty($ar['hint' . $lang_prefix])) {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['hint'] = $ar['hint' . $lang_prefix];
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['active_in_topic'] = $ar['active_in_topic'];
                if (1 === intval(Config::getConfig('apps.table.additional_filtering'))) {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['active_in_optype'] = $ar['active_in_optype'];
                }

                self::$model_storage[$model_name][$table_name][$ar['name']]['group_id'] = $ar['group_id'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['entity'] = $ar['entity'];
                self::$model_storage[$model_name][$table_name][$ar['name']]['combo'] = $ar['combo'];
                if ($ar['parameters'] != '' && $ar['parameters'] != '0') {
                    self::$model_storage[$model_name][$table_name][$ar['name']]['parameters'] = unserialize($ar['parameters']);
                }

                if ($ar['required']) {
                    $required = 'on';
                } else {
                    $required = 'off';
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['required'] = $required;

                if ($ar['unique']) {
                    $unique = 'on';
                } else {
                    $unique = 'off';
                }
                self::$model_storage[$model_name][$table_name][$ar['name']]['unique'] = $unique;
            }
        } else {
            $model_data = self::$model_storage[$model_name];
        }
        //dd(self::$model_storage[$input_model_name]);
        $this->meta_loaded = true;

        return self::$model_storage[$input_model_name];
    }
}
