<?php

namespace Sitebill\Entity\app\Helpers;

use Illuminate\Support\Facades\Log;
use Sitebill\Realty\app\Models\Topic;

class Sitebill {
    private static $enable_aside = false;

    public static function topic_menu () {
        //$topics = Topic::all();
        $topics = Topic::where('parent_id', '0')->orWhere('parent_id', null)->orderBy('order', 'ASC')->get();
        foreach ($topics as $topic) {
            $item = [
                'title' => $topic->name,
                'root' => true,
                'page' => $topic->url,
                'new-tab' => false,
            ];
            if ( count($topic->children()->get()) > 0 ) {
                //$item['toggle'] = 'click';
                $item['submenu'] = self::get_childs($topic, $topic->url);
            }
            $ra[] = $item;

        }
        // Log::info($ra);
        return  $ra;
    }

    private static function get_childs ($topic, $url) {
        $ra = array();
        foreach ($topic->children()->get() as $entry) {
            $item = [
                'title' => $entry->name,
                'page' => $url.'/'.$entry->url
            ];
            if ( count($entry->children()->get()) > 0 ) {
                //$item['toggle'] = 'click';
                $item['submenu'] = self::get_childs($entry, $url.'/'.$entry->url);
            }
            $ra[] = $item;
        }
        $submenu = [
            'type' => 'classic',
            'alignment' => 'left',
            'items' => $ra
        ];
        return $submenu;
    }

    public static function aside_visible () {
        $request = request();
        if ( in_array($request->path(), config('sitebill.realty.controllers_urls')) ) {
            self::$enable_aside = true;
        }
        return self::$enable_aside;
    }

    public static function show_aside () {
        self::$enable_aside = true;
    }

    public static function hide_aside () {
        self::$enable_aside = false;
    }

}
