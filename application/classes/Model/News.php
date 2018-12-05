<?php defined('SYSPATH') or die('No direct script access.');

class Model_News extends Model
{
    /**
     * добавляем новость
     *
     * @param $params
     */
    public static function editNews($params)
    {
        if(empty($params)){
            return false;
        }

        $db = Oracle::init();

        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

        $image = (!empty($params['image']) && is_file($path.$params['image'])) ? $params['image'] : '';

        $data = [
            'p_type_id' 	    => 0,
            'p_announce' 	    => 'анонс',
            'p_title' 		    => $params['title'],
            'p_content' 	    => $params['text'],
            'p_picture' 	    => $image,
            'p_is_published' 	=> 1,
            'p_error_code' 	    => 'out',
        ];

        if(!empty($params['id'])) {
            $preData = ['p_news_id' => $params['id']];

            $res = $db->procedure('news_modify', array_merge($preData, $data));
        } else {
            $user = Auth::instance()->get_user();
            $preData = ['p_agent_id' => $user['AGENT_ID']];

            $res = $db->procedure('news_add', array_merge($preData, $data));
        }

        if($res == Oracle::CODE_ERROR){
            return false;
        }
        return true;
    }
}