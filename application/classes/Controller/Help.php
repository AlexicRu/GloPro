<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Help extends Controller_Common
{
    protected $_search;
    protected $_ids;
    protected $_params;
    protected $_user;
    protected $_result  = [];
    protected $_more    = false;

    public function before()
    {
        parent::before();

        $this->_params = $this->request->post('params');
        $this->_search = $this->request->post('search');
        $this->_ids = $this->request->post('ids');

        if(!empty($this->_ids) && is_string($this->_ids)){
            $this->_ids = explode(',', $this->_ids);
        }

        $this->_user = Auth::instance()->get_user();

        $this->_params['search']        = $this->_search;
        $this->_params['ids']           = $this->_ids;
        $this->_params['offset']        = $this->request->post('offset');
        $this->_params['pagination']    = true;
    }

    public function after($success = true)
    {
        $this->jsonResult($success, ['items' => $this->_result, 'more' => $this->_more]);
    }

    /**
     * получаем список точек для combobox
     */
    public function action_listCardGroup()
    {
        $this->_params['group_type'] = $this->request->query('group_type');

        list($result, $this->_more) = Model_Card::getGroups($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['GROUP_NAME'],
                'value' => $item['GROUP_ID'],
            ];
        }
    }

    /**
     * получаем список точек для combobox
     */
    public function action_listPosGroup()
    {
        list($result, $this->_more) = Model_Dot::getGroups($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['GROUP_NAME'],
                'value' => $item['GROUP_ID'],
            ];
        }
    }

    /**
     * получаем список стран для combobox
     */
    public function action_listCountry()
    {
        list($result, $this->_more) = Listing::getCountries($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['NAME_RU'],
                'value' => $item['ID'],
            ];
        }
    }

    /**
     * получаем список услуг для combobox
     */
    public function action_listService()
    {
        list($result, $this->_more) = Listing::getServices($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['LONG_DESC'],
                'value' => $item['SERVICE_ID'],
            ];
        }
    }

    /**
     * получаем список карт для combobox
     */
    public function action_listCard()
    {
        $this->_params['contract_id'] = $this->request->post('contract_id');

        list($result, $this->_more) = Listing::getCards($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['CARD_ID'],
                'value' => $item['CARD_ID'],
            ];
        }
    }

    /**
     * получаем список доступных карт для combobox
     */
    public function action_listCardsAvailable()
    {
        list($result, $this->_more) = Listing::getCardsAvailable($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['CARD_ID'],
                'value' => $item['CARD_ID'],
            ];
        }
    }

    /**
     * получаем список клиентов для combobox
     */
    public function action_listClient()
    {
        list($result, $this->_more) = Model_Manager::getClientsList($this->_params);

        if(empty($result)) {
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['CLIENT_NAME'],
                'value' => $item['CLIENT_ID'],
            ];
        }
    }

    /**
     * получаем список клиентов для combobox
     */
    public function action_listSupplier()
    {
        list($result, $this->_more) = Listing::getSuppliers($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['SUPPLIER_NAME'],
                'value' => $item['ID'],
            ];
        }
    }

    /**
     * получаем список клиентов для combobox
     */
    public function action_listManager()
    {
        $this->_params['only_managers'] = true;
        $this->_params['agent_id']      = $this->_user['AGENT_ID'];
        $this->_params['manager_id']    = $this->_ids;

        list($result, $this->_more) = Model_Manager::getManagersList($this->_params);

        if(empty($res)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['M_NAME'],
                'value' => $item['MANAGER_ID'],
            ];
        }
    }

    /**
     * получаем список клиентов для combobox
     */
    public function action_listManagerSale()
    {
        $this->_params['role_id'] = [
            Access::ROLE_MANAGER_SALE,
            Access::ROLE_MANAGER_SALE_SUPPORT,
        ];
        $this->_params['agent_id'] = $this->_user['AGENT_ID'];
        $this->_params['manager_id'] = $this->_ids;

        list($result, $this->_more) = Model_Manager::getManagersList($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['M_NAME'],
                'value' => $item['MANAGER_ID'],
            ];
        }
    }

    /**
     * получаем список контрактов клиентов для combobox
     * _depend
     */
    public function action_listClientsContracts()
    {
        $this->_params['client_id'] = $this->_params['client_id'] ?? $this->request->post('client_id');

        if(empty($this->_params['client_id']) && empty($this->_ids)){
            $this->after(false);
        }

        $params = $this->_params;

        if (!empty($this->_ids)) {
            $params['contract_id'] = $this->_ids;
        }

        list($result, $this->_more) = Model_Contract::getContracts($params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => $item['CONTRACT_NAME'],
                'value' => $item['CONTRACT_ID'],
            ];
        }
    }

    /**
     * получаем список контрактов поставщика для combobox
     * _depend
     */
    public function action_listSuppliersContracts()
    {
        $supplierId = $this->request->post('supplier_id');

        list($result, $this->_more) = Listing::getSuppliersContracts($supplierId, $this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $return[] = [
                'name'  => $item['CONTRACT_NAME'],
                'value' => $item['CONTRACT_ID'],
            ];
        }
    }

    /**
     * получаем список доступных тарифов
     */
    public function action_listContractTariffs()
    {
        list($result, $this->_more) = Model_Contract::getTariffs($this->_params);

        if (empty($result)) {
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => '['. $item['ID'] .'] ' . $item['TARIF_NAME'],
                'value' => $item['ID'],
            ];
        }
    }

    /**
     * получаем список клиентов для combobox
     */
    public function action_listTube()
    {
        list($result, $this->_more) = Listing::getTubes($this->_params);

        if(empty($result)){
            $this->after(false);
        }

        foreach($result as $item){
            $this->_result[] = [
                'name'  => ($item['CURRENT_STATE'] == Model_Tube::STATE_INACTIVE ? '[Не в работе] ' : '') . $item['TUBE_NAME'],
                'value' => $item['TUBE_ID'],
            ];
        }
    }
}
