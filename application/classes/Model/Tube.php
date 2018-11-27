<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tube extends Model
{
    const STATE_ACTIVE = 'В работе';
    const STATE_INACTIVE = 'Не в работе';

    const TUBE_SERVICE_ADD = 'add';
    const TUBE_SERVICE_DELETE = 'delete';

    /**
     * получаем список труб
     *
     * @return array|bool
     */
    public static function getTubes($params = [])
    {
        $db = Oracle::init();

        $user = User::current();

        $sql = (new Builder())->select()
            ->from('V_WEB_TUBES_LIST')
            ->where('agent_id = '.$user['AGENT_ID'])
        ;

        if (isset($params['is_owner'])) {
            $sql->where('is_owner = ' . $params['is_owner']);
        }
        if (isset($params['card_limit_change_id'])) {
            $sql->where('card_limit_change_id = ' . $params['card_limit_change_id']);
        }

        return $db->query($sql);
    }

    /**
     * старт загрузки получения списка карт
     *
     * @param $tubeId
     */
    public static function startCardListLoad($tubeId)
    {
        if (empty($tubeId)) {
            return [0, 'empty params'];
        }

        $db = Oracle::init();
        $user = User::current();

        $data = [
            'p_tube_id' 	    => $tubeId,
            'p_manager_id' 	    => $user['MANAGER_ID'],
            'p_error_code' 	    => 'out',
        ];

        $res = $db->procedure('dic_src_get_tube_cards', $data);

        $error = '';
        $result = 1;

        switch ($res) {
            case Oracle::CODE_ERROR:
                $error = 'Ошибка';
                $result = 0;
                break;
            case Oracle::CODE_ERROR_EXISTS:
                $error = 'Загрузка уже запущена';
                $result = 0;
                break;
        }

        return [$result, $error];
    }

    /**
     * редактирование названия трубы
     *
     * @param $tubeId
     * @param $name
     */
    public static function editTubeName($tubeId, $name)
    {
        if (empty($tubeId) || empty($name)) {
            return [0, 'empty params'];
        }

        $db = Oracle::init();
        $user = User::current();

        $data = [
            'p_tube_id' 	    => $tubeId,
            'p_tube_name' 	    => $name,
            'p_manager_id' 	    => $user['MANAGER_ID'],
            'p_error_code' 	    => 'out',
        ];

        $res = $db->procedure('dic_src_change_tube_name', $data);

        $error = '';
        $result = 1;

        switch ($res) {
            case Oracle::CODE_ERROR:
                $error = 'Ошибка';
                $result = 0;
                break;
            case Oracle::CODE_ERROR_EXISTS:
                $error = 'Изменение имени данного источника невозможно!';
                $result = 0;
                break;
        }

        return [$result, $error];
    }

    /**
     * получаем список доступных для трубы сервисов
     *
     * @param $tubeId
     */
    public static function getTubeServiceAvailable($tubeId)
    {
        if (empty($tubeId)) {
            return false;
        }

        $user = User::current();

        $sql = "
            select * 
            from (
              select vta.AGENT_ID, vta.TUBE_ID, vta.SERVICE_ID, vta.system_service_name 
              from ".Oracle::$prefix."V_WEB_TUBE_SERVICE_AVAILABLE vta 
              minus
              select vl.agent_id, vl.tube_id, vl.service_id, vl.foreign_desc 
              from ".Oracle::$prefix."v_web_service_list vl 
            ) t 
            where t.agent_id = ". $user['AGENT_ID'] ." and t.tube_id = ".(int)$tubeId."        
        ";

        return Oracle::init()->query($sql);
    }

    /**
     * редактирование услуги в трубе
     *
     * @param $tubeId
     * @param $serviceId
     * @param $action
     * @return bool
     */
    public static function editTubeService($tubeId, $serviceId, $action = self::TUBE_SERVICE_ADD)
    {
        if (empty($tubeId) || empty($serviceId)) {
            return false;
        }

        $user = User::current();

        $data = [
            'p_agent_id' 	    => $user['AGENT_ID'],
            'p_tube_id' 	    => $tubeId,
            'p_service_id' 	    => $serviceId,
            'p_action' 	        => $action == self::TUBE_SERVICE_ADD ? 1 : 0,
            'p_manager_id' 	    => $user['MANAGER_ID'],
            'p_error_code' 	    => 'out',
        ];

        $res = Oracle::init()->procedure('dic_srv_card_limit_available', $data);

        if ($res != Oracle::CODE_SUCCESS) {
            return false;
        }
        return true;
    }
}