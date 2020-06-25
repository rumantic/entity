<?php

namespace Sitebill\Entity\app\Models\Meta;

class EntityItem {
    private $column;

    public function __construct($column )
    {
        $this->column = $column;
    }

    public function name() {
        return $this->get_array_value('name');
    }

    public function title() {
        return $this->get_array_value('title');
    }

    public function value() {
        return $this->get_array_value('value');
    }

    public function type() {
        return $this->get_array_value('type');
    }

    public function primary_key_name() {
        return $this->get_array_value('primary_key_name');
    }

    public function primary_key_table() {
        return $this->get_array_value('primary_key_table');
    }

    public function value_string() {
        return $this->get_array_value('value_string');
    }

    public function query() {
        return $this->get_array_value('query');
    }

    public function value_name() {
        return $this->get_array_value('value_name');
    }

    public function title_default() {
        return $this->get_array_value('title_default');
    }

    public function value_default() {
        return $this->get_array_value('value_default');
    }

    public function value_table() {
        return $this->get_array_value('value_table');
    }

    public function value_primary_key() {
        return $this->get_array_value('value_primary_key');
    }

    public function value_field() {
        return $this->get_array_value('value_field');
    }

    public function assign_to() {
        return $this->get_array_value('assign_to');
    }

    public function dbtype() {
        return $this->get_array_value('dbtype');
    }

    public function table_name() {
        return $this->get_array_value('table_name');
    }

    public function primary_key() {
        return $this->get_array_value('primary_key');
    }

    public function primary_key_value() {
        return $this->get_array_value('primary_key_value');
    }

    public function action() {
        return $this->get_array_value('action');
    }

    public function select_data() {
        return $this->get_array_value('select_data');
    }


    public function tab() {
        return (empty($this->get_array_value('tab')) ? trans('sitebill::entity.main_tab') : $this->get_array_value('tab'));
    }

    public function hint() {
        return $this->get_array_value('hint');
    }

    public function active_in_topic() {
        return $this->get_array_value('active_in_topic');
    }

    public function group_id() {
        return $this->get_array_value('group_id');
    }

    public function entity() {
        return $this->get_array_value('entity');
    }

    public function combo() {
        return $this->get_array_value('combo');
    }

    public function parameters() {
        return $this->get_array_value('parameters');
    }

    public function required() {
        return ($this->get_array_value('required') == 'on');
    }

    public function unique() {
        return ($this->get_array_value('unique') == 'on');
    }

    private function get_array_value ($key) {
        return (empty($this->column[$key]) ? '' : $this->column[$key]);
    }
}
