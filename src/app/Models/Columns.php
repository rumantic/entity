<?php

namespace Sitebill\Entity\app\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Sitebill\Entity\app\Models\Meta\EntityItem;
use Spatie\Permission\Traits\HasRoles;

class Columns extends Model
{
    use CrudTrait;
    use HasRoles;

    use \Sitebill\Entity\app\Models\Traits\Meta;

    protected $table = 'columns';
    protected $primaryKey = 'columns_id';
    protected $guarded = ['columns_id'];

    public function get_all_columns () {
        $result = collect();

        $column_items = [
            'columns_id' => [
                'name' => 'columns_id',
                'title' => 'ID',
                'type' => 'primary_key',
            ],
            'active' => [
                'name' => 'active',
                'title' => 'Колонка активна',
                'type' => 'checkbox',
                'required' => 'off',
            ],
            'dbtype' => [
                'name' => 'dbtype',
                'title' => 'Хранить значение поля в таблице',
                'type' => 'checkbox',
                'required' => 'off',
            ],
            'required' => [
                'name' => 'required',
                'title' => 'Обязательное поле',
                'type' => 'checkbox',
                'required' => 'off',
            ],
            'unique' => [
                'name' => 'unique',
                'title' => 'Уникальное поле',
                'type' => 'checkbox',
                'required' => 'off',
            ],
            'sort_order' => [
                'name' => 'sort_order',
                'title' => 'Порядок сортировки',
                'type' => 'hidden',
                'required' => 'off',
            ],
            'table_id' => [
                'name' => 'table_id',
                'title' => 'Таблица',
                'type' => 'select_by_query',
                'required' => 'on',
                'primary_key_name' => 'table_id',
                'primary_key_table' => 'table',
                'value_name' => 'name',
                'title_default' => 'выбрать таблицу',
                'value_default' => 0,
            ],
            'type' => [
                'name' => 'type',
                'title' => 'Тип записи',
                'type' => 'select_box',
                'required' => 'on',
                'select_data' => $this->get_types(),
            ],
            'name' => [
                'name' => 'name',
                'title' => 'Название колонки (системное только латиница)',
                'type' => 'safe_string',
                'required' => 'on',
            ],
            'title' => [
                'name' => 'title',
                'title' => 'Название колонки (для человека)',
                'type' => 'safe_string',
                'required' => 'on',
            ],
            'hint' => [
                'name' => 'hint',
                'title' => 'Подсказка',
                'type' => 'safe_string',
                'required' => 'off',
            ],
            'tab' => [
                'name' => 'tab',
                'title' => 'Имя вкладки в форме. Если не указано, то размешается во вкладке по-умолчанию',
                'type' => 'safe_string',
                'required' => 'off',
            ],
            'group_id' => [
                'label'     => 'Доступен для ролей (по-умолчанию доступно всем)',
                'type'      => 'checklist',
                'name'      => 'roles',
                'entity'    => 'roles',
                'attribute' => 'name',
                'model'     => "Backpack\PermissionManager\app\Models\Role",
                'pivot'     => true,
                'tab'       => 'Основное',
            ],
            'active_in_topic' => [
                'name' => 'active_in_topic',
                'title' => 'Активно в категории (по-умолчанию активно везде)',
                'type' => 'select_by_query',
                'required' => 'off',
                'primary_key_name' => 'id',
                'primary_key_table' => 'topic',
                'value_name' => 'name',
                'title_default' => 'выбрать категорию',
                'value_default' => 0,
            ],
            'value' => [
                'name' => 'value',
                'title' => 'Значение по-умолчанию',
                'type' => 'safe_string',
                'required' => 'off',
            ],
            'primary_key_table' => [
                'name' => 'primary_key_table',
                'title' => 'Название таблицы из которой получаем данные для связки',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'primary_key_name' => [
                'name' => 'primary_key_name',
                'title' => 'Название ключа связки с другой таблицей',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'value_name' => [
                'name' => 'value_name',
                'title' => 'Название переменной для select_box',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            /*
            'query' => [
                'name' => 'query',
                'title' => 'SQL-запрос для получения списка записей из связанной таблицы',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            */
            'title_default' => [
                'name' => 'title_default',
                'title' => 'Заголовок строчки в select_box по-умолчанию',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'value_default' => [
                'name' => 'value_default',
                'title' => 'Значение строчки в select_box по-умолчанию',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'value_table' => [
                'name' => 'value_table',
                'title' => 'value_table',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'value_primary_key' => [
                'name' => 'value_primary_key',
                'title' => 'value_primary_key',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'value_field' => [
                'name' => 'value_field',
                'title' => 'value_field',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'assign_to' => [
                'name' => 'assign_to',
                'title' => 'assign_to',
                'type' => 'safe_string', // @todo: определить тип
                'required' => 'off',
            ],
            'select_data' => [
                'name' => 'select_data',
                'title' => 'Набор опций выбора в формате пар {key~~value}',
                'type' => 'textarea',
                'required' => 'off',
            ],
            'entity' => [
                'name' => 'entity',
                'title' => 'Сущность структуры',
                'type' => 'safe_string',
                'required' => 'off',
            ],
            [
                'name'            => 'parameters',
                'label'           => 'Параметры',
                'type'            => 'table',
                'entity_singular' => 'параметр', // used on the "Add X" button
                'columns'         => [
                    'name'  => 'Название',
                    'value'  => 'Значение',
                ],
                //'max' => 5, // maximum rows allowed in the table
                'min' => 0, // minimum rows allowed in the table
                'tab' => 'Параметры',
            ],
            /*
            [
                'label'             => 'Активно в категории (по-умолчанию активно везде)',
                'type'              => 'select2_multiple',
                'name'              => 'active_in_topic', // the method that defines the relationship in your Model
                'entity'            => 'topic_id_rel', // the method that defines the relationship in your Model
                'attribute'         => 'id', // foreign key attribute that is shown to user
                'model'             => "Sitebill\Realty\app\Models\Topic", // foreign key model
                'allows_null'       => true,
                'pivot'             => true, // on create&update, do you need to add/delete pivot table entries?
                'tab'               => 'Основное',
                'wrapperAttributes' => ['class' => 'form-group col-md-6'],
            ],
            */



            /*
            'group_id' => [
                'name' => 'group_id',
                'title' => 'Доступен для ролей (по-умолчанию доступно всем)',
                'type' => 'select_by_query',
                'required' => 'off',
                'primary_key_name' => 'id',
                'primary_key_table' => 'roles',
                'value_name' => 'name',
                'title_default' => 'выбрать роль',
                'value_default' => 0,
            ],
            */
        ];
        foreach ( $column_items as $column_name => $column_item ) {
            $entity_item = new EntityItem($column_item);
            $result->put($column_name, $entity_item);
        }

        return $result;
    }

    protected function get_types () {
        $seld=array(
            /*'avatar' => 'avatar',*/
            'primary_key' => 'primary_key (ключевое поле)',
            'safe_string' => 'safe_string (строка)',
            'hidden' => 'hidden (скрытое поле)',
            'checkbox' => 'checkbox (галочка)',
            'select_box_structure' => 'select_box_structure (выбор типа из списка)',
            'select_by_query' => 'select_by_query (выбор из списка записей из базы)',
            'select_entity' => 'select_entity',
            'select_box' => 'select_box (выбор из списка статичных значений)',
            'auto_add_value' => 'auto_add_value',
            'price' => 'price (цена)',
            'textarea' => 'textarea (поле ввода текста)',
            'uploadify_image' => 'uploadify_image (устарело)',
            'uploadify_file' => 'uploadify_file (устарело)',
            'mobilephone' => 'mobilephone (мобильный телефон)',
            'password' => 'password (пароль)',
            'photo' => 'photo (фото - аватар)',
            'geodata' => 'geodata (координаты)',
            'structure' => 'structure (структура)',
            'textarea_editor' => 'textarea_editor (поле ввода текста с редактором)',
            'date'=>'date (дата DD.MM.YYYY)',
            'attachment'=>'attachment (вложение)',
            'tlocation'=>'tlocation (связанные списки географии)',
            'captcha'=>'captcha (защитный код)',
            'dtdatetime'=>'dtdatetime (дата и время DD.MM.YYYY H:i:s)',
            'dtdate'=>'dtdate (дата DD.MM.YYYY)',
            'dttime'=>'dttime (время H:i:s)',
            'uploads'=>'uploads (загрузка фотографий)',
            'gadres' => 'gadres',
            'client_id' => 'client_id (связь с таблицей клиентов)',
            'grade'=>'grade (оценка)',
            'docuploads'=>'docuploads (загрузка документов)',
            'select_by_query_multi'=>'select_by_query_multi (выбор из списка записей из базы с множественным выбором)',
            'separator'=>'separator (визуальный разделитель)',
            'injector'=>'injector (код из компонента)',
            'parameter'=>'parameter (свободный ввод параметров key=value)',
            'compose'=>'compose (Объединение колонок и функций)'
        );
        asort($seld);
        return $seld;
    }

    public function table_id_rel()
    {
        return $this->belongsTo('Sitebill\Entity\app\Models\Table', 'table_id');
    }

    public function group_id_rel()
    {
        return $this->belongsTo('Backpack\PermissionManager\app\Models\Role', 'id');
    }

    public function active_in_topic_rel()
    {
        return $this->belongsTo('Sitebill\Realty\app\Models\Topic', 'id');
    }


}
