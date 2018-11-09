<?php defined('SYSPATH') or die('No direct script access.');

class Listing
{
    const SERVICE_GROUP_FUEL = 'Топливо';
    const SERVICE_GROUP_WASH = 'Услуги мойки';

    /**
     * список стран
     *
     * @param $params
     * @return array|bool|int
     */
    public static function getCountries($params)
    {
        $db = Oracle::init();

        $sql = (new Builder())->select()
            ->from('V_WEB_DIC_COUNTRY t')
            ->orderBy('t.name_ru')
        ;

        if(!empty($params['search'])){
            $sql->where("upper(t.NAME_RU) like ".mb_strtoupper(Oracle::quoteLike('%'.$params['search'].'%')));
        }

        if(!empty($params['ids'])){
            $sql->where("t.id in (".implode(',', $params['ids']).")");
        }

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * список услуг
     *
     * @param $params
     * @return array|bool|int
     */
    public static function getServices($params = [])
    {
        $user = Auth::instance()->get_user();

        if (!empty($params['description'])) {
            $description = $params['description'];
        }else{
            $description = 'LONG_DESC';
            if (array_key_exists('TUBE_ID', $params)) {
                $description = 'FOREIGN_DESC';
            }
        }

        $sql = (new Builder())->select([
                't.SERVICE_ID',
                't.' . $description
            ])->distinct()
            ->from('V_WEB_SERVICE_LIST t')
            ->where('t.agent_id = ' . $user['AGENT_ID'])
            ->orderBy('t.' . $description)
        ;

        if(!empty($params['ids'])){
            $sql->where('t.SERVICE_ID in ('.implode(',', $params['ids']).')');
        } else {

            if (!empty($params['search'])) {
                $sql->where("upper(t.long_desc) like " . mb_strtoupper(Oracle::quoteLike('%' . $params['search'] . '%')));
            }

            if (!empty($params['TUBE_ID'])) {
                $sql->where("t.TUBE_ID = " . intval($params['TUBE_ID']));
            }

            if (!empty($params['SYSTEM_SERVICE_CATEGORY'])) {
                $sql->columns([
                    't.SYSTEM_SERVICE_CATEGORY'
                ]);
            }
        }

        $db = Oracle::init();

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * список карт
     *
     * @param array $params
     * @param array $ids
     * @return array|bool|int
     */
    public static function getCards($params)
    {
        $db = Oracle::init();

        $user = User::current();

        $sql = (new Builder())->select()
            ->from('V_WEB_CARDS_ALL t')
            ->where('t.agent_id = ' . $user['AGENT_ID'])
            ->orderBy('t.card_id')
        ;

        if(!empty($params['ids'])){
            $sql->whereIn("t.CARD_ID", $params['ids']);
        } else {
            if(!empty($params['search'])){
                $sql->where("t.CARD_ID like ".Oracle::quoteLike('%'.$params['search'].'%'));
            }
            if(!empty($params['contract_id'])){
                $sql->where("t.contract_id = ".(int)$params['contract_id']);
            }
        }

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * список карт
     *
     * @param array $params
     * @return array|bool|int
     */
    public static function getCardsAvailable($params)
    {
        if(empty($params['search']) && empty($params['ids'])){
            return false;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        $sql = (new Builder())->select()
            ->from('V_WEB_CRD_AVAILABLE t')
            ->where('t.agent_id = ' . $user['AGENT_ID'])
            ->orderBy('t.card_id')
        ;

        if(!empty($params['search'])){
            $sql->where("t.CARD_ID like ".Oracle::quoteLike('%'.$params['search'].'%'));
        }

        if(!empty($params['ids'])){
            $sql->whereIn('t.CARD_ID', $params['ids']);
        }

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * список поставщиков
     *
     * @param $params
     * @return array|bool|int
     */
    public static function getSuppliers($params)
    {
        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        $sql = (new Builder())->select()
            ->from('V_WEB_SUPPLIERS_LIST t')
            ->where('t.agent_id = ' . $user['AGENT_ID'])
        ;

        if(!empty($params['search'])){
            $sql->where("upper(t.SUPPLIER_NAME) like ".mb_strtoupper(Oracle::quoteLike('%'.$params['search'].'%')));
        }

        if(!empty($params['ids'])){
            $sql->whereIn('t.ID', $params['ids']);
        }

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * список контрактов поставщиков
     *
     * @param $params
     * @return array|bool|int
     */
    public static function getSuppliersContracts($supplierId, $params = [])
    {
        if(empty($supplierId)){
            return false;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        $sql = (new Builder())->select()
            ->from('V_WEB_SUPPLIERS_CONTRACTS t')
            ->where("t.agent_id = ".$user['AGENT_ID'])
            ->where("t.supplier_id = ".(int)$supplierId)
        ;

        if (!empty($params['search'])) {
            $sql->where("upper(t.CONTRACT_NAME) like ".mb_strtoupper(Oracle::quoteLike('%'.$params['search'].'%')));
        }

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * список труб
     *
     * @param $params
     * @return array|bool|int
     */
    public static function getTubes($params)
    {
        $db = Oracle::init();

        $user = User::current();

        $sql = (new Builder())->select()
            ->from('V_WEB_TUBES_LIST t')
            ->where('t.agent_id = '.$user['AGENT_ID'])
        ;

        if(!empty($params['search'])){
            $sql->where("upper(t.TUBE_NAME) like ".mb_strtoupper(Oracle::quoteLike('%'.$params['search'].'%')));
        }

        if(!empty($params['ids'])){
            $sql->whereIn("t.TUBE_ID", $params['ids']);
        }

        if (!empty($params['pagination'])) {
            return $db->pagination($sql, $params);
        }

        return $db->query($sql);
    }

    /**
     * получаем список агентов
     *
     * @return array|bool
     */
    public static function getAgents()
    {
        $db = Oracle::init();

        $sql = (new Builder())->select(['group_id', 'group_name'])->distinct()
            ->from('V_WEB_AGENTS_LIST')
        ;

        return $db->query($sql);
    }
}