<?php defined('SYSPATH') or die('No direct script access.');

class Model_Manager extends Model
{
    const STATE_MANAGER_ACTIVE      = 1;
    const STATE_MANAGER_BLOCKED     = 4;

    /**
     * радактируем данные юзверя
     *
     * @param $params
     * @param bool|false $userId
     */
    public static function edit($params, $user = false)
    {
        if(empty($user)){
            $user = Auth::instance()->get_user();
        }

        if(
            empty($user['MANAGER_ID']) ||
            empty($user['role'])
        ){
            return false;
        }

        $db = Oracle::init();

        $data = [
            'p_manager_id' 	=> $user['MANAGER_ID'],
            'p_role_id' 	=> $user['role'],
            'p_name' 	    => empty($params['manager_settings_name'])         ? '' : $params['manager_settings_name'],
            'p_surname' 	=> empty($params['manager_settings_surname'])      ? '' : $params['manager_settings_surname'],
            'p_middlename' 	=> empty($params['manager_settings_middlename'])   ? '' : $params['manager_settings_middlename'],
            'p_phone' 		=> empty($params['manager_settings_phone'])        ? '' : $params['manager_settings_phone'],
            'p_email' 		=> empty($params['manager_settings_email'])        ? '' : $params['manager_settings_email'],
            'p_error_code' 	=> 'out',
        ];

        $res = $db->procedure('manager_edit', $data);

        if($res == Oracle::CODE_ERROR){
            return false;
        }

        if(
            !empty($params['manager_settings_password']) && !empty($params['manager_settings_password_again']) &&
            $params['manager_settings_password'] == $params['manager_settings_password_again'] &&
            $user['MANAGER_ID'] != Access::USER_TEST
        ){
            //обновление паролей

            $data = [
                'p_manager_id' 	    => $user['MANAGER_ID'],
                'p_new_password'    => empty($params['manager_settings_password'])      ? '' : $params['manager_settings_password'],
                'p_error_code' 	    => 'out',
            ];

            $res = $db->procedure('manager_change_password', $data);

            if(!empty($res)){
                return false;
            }
        }

        Auth::instance()->regenerate_user_profile();

        return true;
    }

    /**
     * список менеджеров
     *
     * @param $params
     * @return array|bool|int
     */
    public static function getManagersList($params = [])
    {
        $db = Oracle::init();

        $sql = "select * from ".Oracle::$prefix."V_WEB_MANAGERS where MANAGER_ID != 0 ";

        if(!empty($params['search'])){
            $params['search'] = mb_strtoupper($params['search']);
            $sql .= " and (
                upper(MANAGER_NAME) like '%". Oracle::quote($params['search'])."%' or 
                upper(MANAGER_SURNAME) like '%". Oracle::quote($params['search'])."%' or 
                upper(MANAGER_MIDDLENAME) like '%". Oracle::quote($params['search'])."%' or
                upper(M_NAME) like '%". Oracle::quote($params['search'])."%'
            )";
        }
        unset($params['search']);

        if(!empty($params['only_managers'])){
            $sql .= " and ROLE_ID not in (".implode(', ', Access::$usersRoles).")";
        }
        unset($params['only_managers']);

        foreach($params as $key => $value){
            $sql .= " and ".strtoupper($key)." = '". Oracle::quote($value)."' ";
        }

        $sql .= ' order by MANAGER_NAME';

        $users = $db->query($sql);

        if(empty($users)){
            return false;
        }

        foreach($users as &$user){
            $user['role'] = $user['ROLE_ID'];
        }

        return $users;
    }

    /**
     * получаем менеджера
     */
    public static function getManager($params)
    {
        if(empty($params)){
            return false;
        }

        if(!is_array($params)){
            $params = ['manager_id' => (int)$params];
        }

        $managers = self::getManagersList($params);

        if(empty($managers)){
            return false;
        }

        return reset($managers);
    }

    /**
     * блокировка/разблокировка
     *
     * @param $cardId
     */
    public static function toggleStatus($params)
    {
        if(empty($params['manager_id'])){
            return false;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        //получаем карты и смотрим текущий статус у нее
        $manager = self::getManager($params['manager_id']);

        if(empty($manager['MANAGER_ID'])){
            return false;
        }

        switch($manager['STATE_ID']){
            case self::STATE_MANAGER_ACTIVE:
                $status = self::STATE_MANAGER_BLOCKED;
                break;
            default:
                $status = self::STATE_MANAGER_ACTIVE;
        }

        $data = [
            'p_manager_for_id' 	=> $manager['MANAGER_ID'],
            'p_new_status' 		=> $status,
            'p_manager_who_id' 	=> $user['MANAGER_ID'],
            'p_error_code' 		=> 'out',
        ];

        $res = $db->procedure('ctrl_manager_change_status', $data);

        if(empty($res)){
            return true;
        }

        return false;
    }

    /**
     * у выбранного менеджера удаляем клиента
     *
     * @param $managerId
     * @param $clientId
     */
    public static function delClient($managerId, $clientId)
    {
        if(empty($managerId) || empty($clientId)){
            return Oracle::CODE_ERROR;
        }

        $user = Auth::instance()->get_user();

        $db = Oracle::init();

        $data = [
            'p_manager_for_id' 	=> $managerId,
            'p_client_id' 		=> $clientId,
            'p_manager_who_id' 	=> $user['MANAGER_ID'],
            'p_error_code' 		=> 'out',
        ];

        $res = $db->procedure('ctrl_manager_client_del', $data);

        if($res == Oracle::CODE_ERROR){
            return Oracle::CODE_ERROR;
        }

        return Oracle::CODE_SUCCESS;
    }

    /**
     * добавляем менеджера
     *
     * @param $params
     */
    public static function addManager($params)
    {
        if(empty($params['role']) || empty($params['login']) || empty($params['password'])){
            return false;
        }
        if($params['password'] != $params['password_again']){
            return false;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        $data = [
            'p_manager_role_id' 	=> $params['role'],
            'p_manager_name' 	    => empty($params['name']) ? '' : $params['name'],
            'p_manager_surname' 	=> empty($params['surname']) ? '' : $params['surname'],
            'p_manager_midname' 	=> empty($params['middlename']) ? '' : $params['middlename'],
            'p_login' 	            => $params['login'],
            'p_password' 	        => $params['password'],
            'p_phone' 	            => empty($params['phone']) ? '' : $params['phone'],
            'p_email' 	            => empty($params['email']) ? '' : $params['email'],
            'p_manager_id' 		    => $user['MANAGER_ID'],
            'p_new_manager_id' 		=> 'out',
            'p_error_code' 		    => 'out',
        ];

        $res = $db->procedure('ctrl_manager_add', $data, true);

        if($res['p_error_code'] == Oracle::CODE_ERROR){
            return false;
        }
        return $res['p_new_manager_id'];
    }

    /**
     * добавляем клиентов
     *
     * @param $params
     */
    public static function addClients($params)
    {
        if(empty($params['ids']) || empty($params['manager_id'])){
            return false;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        foreach($params['ids'] as $id){
            $data = [
                'p_manager_for_id' 	=> $params['manager_id'],
                'p_client_id' 	    => $id,
                'p_manager_who_id' 	=> $user['MANAGER_ID'],
                'p_error_code' 		=> 'out',
            ];

            $res = $db->procedure('ctrl_manager_client_add', $data);

            if($res == Oracle::CODE_ERROR){
                return false;
            }
        }

        return true;
    }

    /**
     * получаем список доступный клиентов по манагеру
     *
     * @param array $params
     * @return array
     */
    public static function getClientsList($params = [])
    {
        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        if (empty($params['manager_id'])) {
            $managerId = $user['MANAGER_ID'];
        } else {
            $managerId = $params['manager_id'];
        }

        if (empty($params['agent_id'])) {
            $agentId = $user['AGENT_ID'];
        } else {
            $agentId = $params['agent_id'];
        }

        $sql = "select *
            from ".Oracle::$prefix."V_WEB_CLIENTS_LIST t 
            where t.agent_id = ".$agentId."
            and not exists
            (
                select 1 
                from ".Oracle::$prefix."V_WEB_MANAGER_CLIENTS vwc 
                where vwc.client_id = t.client_id and vwc.agent_id = t.agent_id and vwc.manager_id = ".$managerId."
            )";

        if(!empty($params['search'])){
            $sql .= " and upper(t.NAME) like '%" . mb_strtoupper(Oracle::quote($params['search'])) . "%'";
        }

        $sql .= " order by t.client_id desc ";

        return $db->query($sql);
    }
}