<?php defined('SYSPATH') or die('No direct script access.');

class Api
{
    const DB_API_PACK = 'api_pack.';

    private $_db;
    private $_errors = [];

    public function __construct()
    {
        $this->_db = Oracle::init();
        //$this->_db->setPack(self::DB_API_PACK);
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * получение токена
     */
    public function getToken($userId)
    {
        if (empty($userId)) {
            return false;
        }

        $data = [
            'p_manager_id'  => $userId,
            'p_token'       => 'out',
            'p_error_code'  => 'out'
        ];

        $res = $this->_db->procedure('api_get_token', $data, true);

        if ($res['p_error_code'] == Oracle::CODE_SUCCESS) {
            return $res['p_token'];
        }

        switch ($res['p_error_code']) {
            case 1:
                $this->_errors[] = 'Интерфейс API для пользователя недоступен';
                break;
            case 2:
                $this->_errors[] = 'Срок действия токена истек, получите токен заново';
                break;
            default:
                $this->_errors[] = 'Неизвестная ошибка';
        }

        return false;
    }

    /**
     * проверка токена
     *
     * @param $token
     */
    public function getUserIdByToken($token)
    {
        if (empty($token)) {
            return false;
        }

        $data = [
            'p_token'       => $token,
            'p_manager_id'  => 'out',
            'p_error_code'  => 'out'
        ];

        $res = $this->_db->procedure('api_check_token', $data, true);

        if ($res['p_error_code'] == Oracle::CODE_SUCCESS) {
            return $res['p_manager_id'];
        }

        return false;
    }
}