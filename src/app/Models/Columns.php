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
            'name' => [
                'name' => 'name',
                'title' => 'Название колонки (системное только латиница)',
                'type' => 'safe_string',
                'required' => 'on',
            ],
            'type' => [
                'name' => 'type',
                'title' => 'Тип записи',
                'type' => 'select_box',
                'required' => 'on',
                'select_data' => $this->get_types(),
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


}
