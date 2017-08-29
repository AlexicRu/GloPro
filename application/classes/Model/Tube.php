<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tube extends Model
{
    /**
     * получаем список труб
     *
     * @return array|bool
     */
    public static function getTubes()
    {
        $db = Oracle::init();

        $user = User::current();

        $sql = (new Builder())->select()
            ->from('V_WEB_TUBES_LIST')
            ->where('agent_id = '.$user['AGENT_ID'])
        ;

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
}