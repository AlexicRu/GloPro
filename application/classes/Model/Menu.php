<?php defined('SYSPATH') or die('No direct script access.');

class Model_Menu extends Model
{
    /**
     * строим меню
     */
    public static function buildMenu()
    {
        //подключаем меню
        $menu = Kohana::$config->load('menu');
        /*$infoSections = Model_Info::getFiles(['category_id' => 0]);

        foreach ($infoSections as $section) {
            $link = Text::transliterateUrl($section['NAME']);
            $menu['info']['children'][$link] = $section['NAME'];
        }*/

        $content = View::factory('_includes/menu')
            ->bind('menu', $menu);

        View::set_global('menu', $content);
    }

}