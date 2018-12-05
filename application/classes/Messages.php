<?php defined('SYSPATH') or die('No direct script access.');

class Messages
{
    const MESSAGE_TYPE_DANGER   = 'error';
    const MESSAGE_TYPE_INFO     = 'info';
    const MESSAGE_TYPE_WARNING  = 'warning';
    const MESSAGE_TYPE_SUCCESS  = 'success';

    public static $messageIcons = [
        self::MESSAGE_TYPE_DANGER   => 'fa-exclamation-square',
        self::MESSAGE_TYPE_INFO     => 'fa-exclamation-circle',
        self::MESSAGE_TYPE_WARNING  => 'fa-exclamation-triangle',
        self::MESSAGE_TYPE_SUCCESS  => 'fa-check-circle',
    ];

    /**
     * получаем список сообщений, которые надо вывести
     * 
     * @return array|mixed
     * @throws Cache_Exception
     */
    public static function get()
    {
        $cache = Cache::instance();

        $user = User::current();

        $key = 'messages_user'.(!empty($user['MANAGER_ID']) ? $user['MANAGER_ID'] : Session::instance()->id());

        $messages = $cache->get($key);

        if (!empty($messages)) {
            $cache->delete($key);
        }
        
        return $messages ?: [];
    }

    /**
     * в массив сообщений добавляем еще одно
     *
     * @param $text
     * @param $type
     */
    public static function put($text, $type = self::MESSAGE_TYPE_DANGER)
    {
        $messages = self::get();

        $messages[] = ['type' => $type, 'text' => $text];

        $cache = Cache::instance();

        $user = User::current();

        $key = 'messages_user'.(!empty($user['MANAGER_ID']) ? $user['MANAGER_ID'] : Session::instance()->id());

        return $cache->set($key, $messages);
    }
}