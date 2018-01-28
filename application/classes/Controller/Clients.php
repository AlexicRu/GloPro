<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Clients extends Controller_Common {

	public function before()
	{
		parent::before();

		$this->title[] = 'Список клиентов';
	}

	/**
	 * титульная страница со списком клиентов
	 */
	public function action_index()
	{
		$search = $this->request->post('search');

		$clients = Model_Client::getClientsList($search);

        $popupClientAdd = Common::popupForm('Добавление нового клиента', 'client/add');

        $this->tpl
            ->bind('clients', $clients)
            ->bind('popupClientAdd', $popupClientAdd)
        ;
	}

	/**
	 * страница работы с клиентом
	 */
	public function action_client()
	{
		$clientId = $this->request->param('id');
		$contractId = $this->request->query('contract_id') ?: false;

		Access::check('client', $clientId);

		$client = Model_Client::getClient($clientId);
		$contracts = Model_Contract::getContracts($clientId);

		if(empty($client)){
			throw new HTTP_Exception_404();
		}

		$popupContractAdd = Common::popupForm('Добавление нового договора', 'contract/add');
		$popupCabinetCreate = Common::popupForm('Создание личного кабинета', 'client/cabinet_create');

		$this->tpl
			->bind('client', $client)
			->bind('contractId', $contractId)
			->bind('contracts', $contracts)
			->bind('popupContractAdd', $popupContractAdd)
			->bind('popupCabinetCreate', $popupCabinetCreate)
		;
	}

	/**
	 * редактирование клиента
	 */
	public function action_client_edit()
	{
		$clientId = $this->request->param('id');
		$params = $this->request->post('params');

		$result = Model_Client::editClient($clientId, $params);

		if(empty($result)){
			$this->jsonResult(false);
		}
		$this->jsonResult(true);
	}

	/**
	 * грузим данные по контракту
	 */
	public function action_contract()
	{
		$contractId = $this->request->param('id');

		if($contractId == 0){
			$this->html('<div class="error_block">Контракты отсутствуют</div>');
		}

		$tab = $this->request->post('tab');
		$params = $this->request->post('params') ?: [];

		$contract = Model_Contract::getContract($contractId);

		if(empty($contract)){
			$this->html('<div class="error_block">Ошибка</div>');
		}

		$balance = Model_Contract::getContractBalance($contractId);

		switch($tab) {
			case 'contract':
				$contractSettings = Model_Contract::getContractSettings($contractId);
                $contractTariffs = Model_Contract::getTariffs();
                $noticeSettings = Model_Contract::getContractNoticeSettings($contractId);
				$popupContractNoticeSettings = Common::popupForm('Настройка уведомлений', 'contract/notice_settings', ['settings' => $noticeSettings]);
				$popupContractHistory = Common::popupForm('История по договору', 'contract/history');

				$content = View::factory('ajax/clients/contract/contract')
					->bind('contract', $contract)
					->bind('contractSettings', $contractSettings)
					->bind('contractTariffs', $contractTariffs)
					->bind('popupContractNoticeSettings', $popupContractNoticeSettings)
					->bind('popupContractHistory', $popupContractHistory)
				;
				break;
			case 'cards':
				$popupCardAdd = Common::popupForm('Добавление новой карты', 'card/add');

				$cardsCounter = Model_Contract::getCardsCounter($contractId);

				$content = View::factory('ajax/clients/contract/cards')
                    ->bind('params', $params)
					->bind('popupCardAdd', $popupCardAdd)
					->bind('cardsCounter', $cardsCounter)
                ;
				break;
			case 'account':
				$turnover = Model_Contract::getTurnover($contractId);
				$contractLimits = Model_Contract::getLimits($contractId);
                Listing::$limit = 999;
                $servicesList = Listing::getServices(['description' => 'LONG_DESC']);

				$popupContractPaymentAdd = Common::popupForm('Добавление нового платежа', 'contract/payment_add');
                $popupContractBillAdd = Common::popupForm('Выставление счета', 'contract/bill_add');
                $popupContractBillPrint = Common::popupForm('Печать счетов', 'contract/bill_print');
                $popupContractLimitIncrease = Common::popupForm('Изменение лимита', 'contract/increase_limit');

                $popupContractLimitsEdit = Common::popupForm('Редактирование лимитов договора', 'contract/limits_edit', [
                    'contractLimits' 	=> $contractLimits,
                    'servicesList'		=> $servicesList
                ]);

				$content = View::factory('ajax/clients/contract/account')
                    ->bind('balance', $balance)
					->bind('turnover', $turnover)
					->bind('contractLimits', $contractLimits)
					->bind('servicesList', $servicesList)
					->bind('popupContractPaymentAdd', $popupContractPaymentAdd)
                    ->bind('popupContractBillAdd', $popupContractBillAdd)
                    ->bind('popupContractBillPrint', $popupContractBillPrint)
                    ->bind('popupContractLimitsEdit', $popupContractLimitsEdit)
                    ->bind('popupContractLimitIncrease', $popupContractLimitIncrease)
                ;
				break;
			case 'reports':
                $reportsList = Model_Report::getAvailableReports([
                    'report_type_id' => Model_Report::REPORT_TYPE_DB_CLIENT
                ]);

                $reports = Model_Report::separateBuyGroups($reportsList);

				$content = View::factory('ajax/clients/contract/reports')
                    ->bind('reports', $reports)
                ;
				break;
		}

		$html = View::factory('ajax/clients/contract/_tabs')
			->bind('content', $content)
			->bind('balance', $balance)
			->bind('tab', $tab)
		;

		$this->html($html);
	}

	/**
	 * редактирование контракта
	 */
	public function action_contract_edit()
	{
		$contractId = $this->request->param('id');
		$params = $this->request->post('params');

		$result = Model_Contract::editContract($contractId, $params);

		if(empty($result)){
			$this->jsonResult(false);
		}
		$this->jsonResult(true, $result);
	}

    /**
     * грузим данные по карте
     */
    public function action_card()
    {
        $cardId = $this->request->param('id');
		$contractId = $this->request->query('contract_id');

        $card = Model_Card::getCard($cardId, $contractId);

        if(empty($card)){
            $this->html('<div class="error_block">Ошибка</div>');
        }

        $oilRestrictions = Model_Card::getOilRestrictionsV2($cardId);
        $lastFilling = Model_Card::getLastFilling($cardId, $contractId);
        Listing::$limit = 999;
		$servicesList = Listing::getServices(['TUBE_ID' => $card['TUBE_ID']]);

		$popupCardHolderEdit = Common::popupForm('Редактирование держателя карты', 'card/edit_holder', [
            'card' 				=> $card,
		], 'card_edit_holder_'.$cardId);
        $popupCardLimitsEdit = Common::popupForm('Редактирование лимитов карты', 'card/edit_limits', [
            'card' 				=> $card,
            'oilRestrictions' 	=> $oilRestrictions,
            'servicesList'		=> $servicesList
        ], 'card_edit_limits_'.$cardId);

        $html = View::factory('ajax/clients/card')
            ->bind('card', $card)
            ->bind('oilRestrictions', $oilRestrictions)
            ->bind('lastFilling', $lastFilling)
            ->bind('popupCardHolderEdit', $popupCardHolderEdit)
            ->bind('popupCardLimitsEdit', $popupCardLimitsEdit)
        ;

        $this->html($html);
    }

	/**
	 * добавление нового клиента
	 */
	public function action_client_add()
	{
		$params = $this->request->post('params');

		$result = Model_Client::addClient($params);

		if(empty($result)){
			$this->jsonResult(false);
		}
		$this->jsonResult(true, $result);
	}

	/**
	 * добавление контракта
	 *
	 */
	public function action_contract_add()
	{
		$params = $this->request->post('params');

		$result = Model_Contract::addContract($params);

		if(empty($result)){
			$this->jsonResult(false);
		}

		if(!empty($result['error'])){
			$this->jsonResult(false, $result['error']);
		}

		$this->jsonResult(true, $result);
	}

	/**
	 * добавляем новую карту
	 */
	public function action_card_add()
	{
		$params = $this->request->post('params');

		$result = Model_Card::editCard($params, Model_Card::CARD_ACTION_ADD);

		if($result === true){
			$this->jsonResult(true);
		}

		$error = '';
		switch($result){
			case Oracle::CODE_ERROR :
				break;
			case 2:
				$error = 'Карта уже существует';
				break;
			case 3:
				$error = 'Неверный номер карты';
				break;
		}

		$this->jsonResult(false, $error);
	}
    /**
     * редактирование лимитов карты
     */
    public function action_card_edit_limits()
    {
        $cardId     = $this->request->post('card_id');
        $contractId = $this->request->post('contract_id');
        $limits     = $this->request->post('limits');

        list($result, $error) = Model_Card::editCardLimitsV2($cardId, $contractId, $limits);

        $this->jsonResult($result, $error);
    }

	/**
	 * редактирование карты
	 */
	public function action_card_edit_holder()
	{
        $cardId     = $this->request->post('card_id');
        $contractId = $this->request->post('contract_id');
        $holder     = $this->request->post('holder');
        $date       = $this->request->post('date');
        $comment    = $this->request->post('comment');

		$result = Model_Card::editCardHolder($cardId, $contractId, $holder, $date, $comment);

		if(empty($result)){
			$this->jsonResult(false);
		}

		$this->jsonResult(true, $result);
	}

	/**
	 * добавление нового платежа по контракту
	 */
	public function action_contract_payment_add()
	{
        $payments = [$this->request->post('params')];
		$multi = $this->request->post('multi') ?: 0;
        $message = '';

		if(!empty($multi)){
            $payments = $this->request->post('payments');
        }

        foreach($payments as $payment){
            list($result, $message) = Model_Contract::payment(Model_Contract::PAYMENT_ACTION_ADD, $payment);

            if(empty($result)){
                $this->jsonResult(false, $message);
            }
        }

		$this->jsonResult(true, $message);
	}

	/**
	 * удаляем платеж по контракту
	 */
	public function action_contract_payment_delete()
	{
		$params = $this->request->post('params');

		list($result, $message) = Model_Contract::payment(Model_Contract::PAYMENT_ACTION_DELETE, $params);

		if(empty($result)){
			$this->jsonResult(false);
		}

		$this->jsonResult(true);
	}

	/**
	 * генерация отчетов
	 */
	public function action_report()
	{
		$params = $this->request->query();

		$report = Model_Report::generate($params);

		if(empty($report)){
			throw new HTTP_Exception_404();
		}

		foreach($report['headers'] as $header){
			header($header);
		}

		$this->html($report['report']);
	}

	/**
	 * блокируем/разблокируем карту
	 */
	public function action_card_toggle()
	{
		$params = $this->request->post('params');

		$result = Model_Card::toggleStatus($params);

		if(empty($result)){
			$this->jsonResult(false);
		}

		$this->jsonResult(true);
	}

	/**
	 * аяксово+постранично получаем историю операций
	 */
	public function action_card_operations_history()
	{
		$cardId = $this->request->param('id');
		$contractId = $this->request->query('contract_id');
		$params = [
		    'CONTRACT_ID'   => $contractId,
			'offset' 		=> $this->request->post('offset'),
			'pagination'	=> true
		];

		list($operationsHistory, $more) = Model_Card::getOperationsHistory($cardId, $params);

		if(empty($operationsHistory)){
			$this->jsonResult(false);
		}

		$this->jsonResult(true, ['items' => $operationsHistory, 'more' => $more]);
	}

	/**
	 * аяксово+постранично получаем историю операций
	 */
	public function action_account_payments_history()
	{
		$contractId = $this->request->param('id');
		$params = [
			'offset' 		=> $this->request->post('offset'),
			'pagination'	=> true
		];

		list($paymentsHistory, $more) = Model_Contract::getPaymentsHistory($contractId, $params);

		if(empty($paymentsHistory)){
			$this->jsonResult(false);
		}

		$this->jsonResult(true, ['items' => $paymentsHistory, 'more' => $more]);
	}

	/**
	 * создание ЛК для пользователя
	 */
	public function action_cabinet_create()
	{
		$params = $this->request->post('params');

		$result = Model_Client::createCabinet($params);

		if(!empty($result)){
			$this->jsonResult(false, $result);
		}

		$this->jsonResult(true);
	}

	/**
	 * изымаем новую карту
	 */
	public function action_card_withdraw()
	{
		$params = $this->request->post('params');

		$result = Model_Card::withdrawCard($params);

		if($result === true){
			$this->jsonResult(true);
		}

		$this->jsonResult(false);
	}

	/**
	 * список состояний контракта
	 */
	public function action_contract_history()
	{
		if($this->_isPost()) {
			$params = [
				'contract_id'	=> $this->request->post('contract_id'), 
				'offset' 		=> $this->request->post('offset'),
				'pagination' 	=> true
			];

			list($history, $more) = Model_Contract::getHistory($params);

			if(empty($history)){
				$this->jsonResult(false);
			}

			$this->jsonResult(true, ['items' => $history, 'more' => $more]);
		}		
	}

    /**
     * выставляем счет клиенту
     */
	public function action_add_bill()
    {
        $contractId = $this->request->query('contract_id');
        $sum = $this->request->query('sum');
        $products = $this->request->query('products');

        $invoiceNum = Model_Contract::addBill($contractId, $sum, $products);

        $params = [
            'type'              => Model_Report::REPORT_TYPE_BILL,
            'format'            => 'pdf',
            'contract_id'       => $contractId,
            'invoice_number'    => $invoiceNum,
        ];

        $report = Model_Report::generate($params);

        if(empty($report)){
            throw new HTTP_Exception_500('Счет не сформировался');
        }

        foreach($report['headers'] as $header){
            header($header);
        }

        $this->html($report['report']);
    }

    /**
     * настройка уведомлений
     */
    public function action_edit_contract_notices()
    {
        $params = $this->request->post('params');
        $contractId = $this->request->post('contract_id');

        $result = Model_Contract::editNoticesSettings($contractId, $params);

        if(!empty($result)){
            $this->jsonResult(false, $result);
        }

        $this->jsonResult(true);
    }

    /**
     * список выставленных счетов по контракту
     */
    public function action_bills_list()
    {
        $params = [
            'contract_id'	=> $this->request->post('contract_id'),
            'offset' 		=> $this->request->post('offset'),
            'pagination' 	=> true
        ];

        list($history, $more) = Model_Contract::getBillsList($params);

        if(empty($history)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true, ['items' => $history, 'more' => $more]);
    }

    /**
     * грузим список карт
     */
    public function action_cards_list()
    {
        $contractId = $this->request->query('contract_id');
        $query = $this->request->post('query');
        $status = $this->request->post('status');

        $params = [
            'CONTRACT_ID'   => $contractId,
            'offset' 		=> $this->request->post('offset'),
            'pagination'	=> true,
            'limit'	        => 20,
        ];

        if(!empty($query) ){
            $params['query'] = $query;
        }
        if(!empty($status) ){
            $params['status'] = $status;
        }

        list($cards, $more) = Model_Card::getCards($contractId, false, $params);

        if(empty($cards)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true, ['items' => $cards, 'more' => $more]);
    }

    /**
     * редактируем логин пользователя
     */
    public function action_edit_login()
    {
        $login = $this->request->post('login');
        $managerId = $this->request->post('manager_id');

        $result = Model_Manager::editLogin($managerId, $login);

        if (!empty($result['error'])) {
            $this->jsonResult(false, $result);
        }
        $this->jsonResult(true, $result);
    }

    /**
     * редактирование лимитов договора
     */
    public function action_contract_limits_edit()
    {
        $limits = $this->request->post('limits');
        $contractId = $this->request->post('contract_id');

        $result = Model_Contract::editLimits($contractId, $limits);

        if(empty($result)){
            $this->jsonResult(false);
        }

        $messages = Messages::get();

        if(!empty($messages)){
            $this->jsonResult(false, $messages);
        }

        $this->jsonResult(true, $result);
    }

    /**
     * изменяем лимит
     */
    public function action_contract_increase_limit()
    {
        $amount = $this->request->post('amount');
        $groupId = $this->request->post('group_id');
        $contractId = $this->request->post('contract_id');

        $result = Model_Contract::editLimit($contractId, $groupId, $amount);

        if(empty($result)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true, $result);
    }

    /**
     * отрисовываем блок продукта для выставления счета
     */
    public function action_add_bill_product_template()
    {
        $iteration = $this->request->post('iteration');

        $html = View::factory('ajax/clients/add_bill/product')
            ->bind('iteration', $iteration)
        ;

        $this->html($html);
    }
}