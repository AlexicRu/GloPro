<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Clients extends Controller_Common {

	public function before()
	{
		parent::before();

		$this->title[] = 'Список фирм';
	}

	/**
	 * титульная страница со списком клиентов
	 */
	public function action_index()
	{
        $this->_initEnjoyHint();
        Common::addJs('clients/clients.js');

        $popupClientAdd = Form::popup('Добавление нового клиента', 'client/add');

        $this->tpl
            ->bind('popupClientAdd', $popupClientAdd)
        ;
	}

    /**
     * постраничная загрузка кдиентов
     */
	public function action_clientsList()
    {
        $params = [
            'search'        => $this->request->post('search'),
            'offset' 		=> $this->request->post('offset'),
            'statuses'      => $this->request->post('statuses'),
            'sort'	        => $this->request->post('sort'),
            'sortWay'       => $this->request->post('sortWay'),
            'pagination'	=> true
        ];

        list($clients, $more) = Model_Client::getFullClientsList($params);

        if(empty($clients)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true, ['items' => $clients, 'more' => $more]);
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

        $this->_initEnjoyHint();
        $this->_initPhoneInputWithFlags();
        $this->_initVueJs();

		$popupContractAdd = Form::popup('Добавление нового договора', 'contract/add');
		$popupCabinetCreate = Form::popup('Создание личного кабинета', 'client/cabinet_create');
        $popupClientLoadByInn = Form::popup('Загрузка данных клиента по ИНН', 'client/load_by_inn');

		$this->tpl
			->bind('client', $client)
			->bind('contractId', $contractId)
			->bind('contracts', $contracts)
			->bind('popupContractAdd', $popupContractAdd)
			->bind('popupCabinetCreate', $popupCabinetCreate)
            ->bind('popupClientLoadByInn', $popupClientLoadByInn)
		;
	}

	/**
	 * редактирование клиента
	 */
	public function action_clientEdit()
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
			$this->html('<div class="error_block text-center p-5">Контракты отсутствуют</div>');
		}

		$tab = $this->request->post('tab');
		$params = $this->request->post('params') ?: [];

		$contract = Model_Contract::getContract($contractId);

		if(empty($contract)){
			$this->html('<div class="error_block text-center p-5">Ошибка</div>');
		}

		$balance = Model_Contract::getContractBalance($contractId);

		switch($tab) {
			case 'contract':
				$contractSettings = Model_Contract::getContractSettings($contractId);
                $contractTariffs = Model_Contract::getTariffs();
                $noticeSettings = Model_Contract::getContractNoticeSettings($contractId);
                $contractManagers = Model_Contract::getContractManagers($contractId);

				$popupContractNoticeSettings = Form::popup('Настройка уведомлений', 'contract/notice_settings', [
                    'settings'  => $noticeSettings,
                    'manager'   => User::current()
                ]);
				$popupContractHistory = Form::popupLarge('История по договору', 'contract/history');
                $popupContractTariffEdit = Form::popup('Тариф по договору', 'contract/tariff_edit', [
                    'tariffId' => $contractSettings['TARIF_OFFLINE'],
                    'contractDateBegin' => $contract['DATE_BEGIN'],
                    'contractId' => $contractId,
                ]);

				$content = View::factory('ajax/clients/contract/contract')
					->bind('contract', $contract)
					->bind('contractSettings', $contractSettings)
					->bind('contractTariffs', $contractTariffs)
					->bind('contractManagers', $contractManagers)
					->bind('popupContractNoticeSettings', $popupContractNoticeSettings)
					->bind('popupContractHistory', $popupContractHistory)
					->bind('popupContractTariffEdit', $popupContractTariffEdit)
				;
				break;
			case 'cards':
                $popupCardAdd = Form::popupLarge('Добавление новых карт', 'card/add');

				$cardsCounter = Model_Contract::getCardsCounter($contractId);

				$content = View::factory('ajax/clients/contract/cards')
                    ->bind('contract', $contract)
                    ->bind('params', $params)
					->bind('popupCardAdd', $popupCardAdd)
					->bind('cardsCounter', $cardsCounter)
                ;
				break;
			case 'account':
				$turnover = Model_Contract::getTurnover($contractId);
				$contractLimits = Model_Contract::getLimits($contractId);
                $servicesList = Listing::getServices(['description' => 'LONG_DESC']);

				$popupContractPaymentAdd = Form::popup('Добавление нового платежа', 'contract/payment_add');
                $popupContractBillAdd = Form::popupLarge('Выставление счета', 'contract/bill_add');
                $popupContractBillPrint = Form::popupLarge('Печать счетов', 'contract/bill_print');
                $popupContractLimitIncrease = Form::popup('Изменение лимита', 'contract/increase_limit');

                $popupContractLimitsEdit = Form::popupLarge('Редактирование ограничений по топливу', 'contract/limits_edit', [
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
	public function action_contractEdit()
	{
		$contractId = $this->request->param('id');
		$params = $this->request->post('params');

		$result = Model_Contract::editContract($contractId, $params);

		if(empty($result)){
			$this->jsonResult(false);
		}
		$this->jsonResult(true, [
		    'full_reload' => !empty($params['contract']['STATE_ID']) && $params['contract']['STATE_ID'] == Model_Contract::STATE_CONTRACT_DELETED ? true : false
        ]);
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
            $this->html('<div class="error_block text-center p-5">Ошибка</div>');
        }

        $oilRestrictions = Model_Card::getOilRestrictions($cardId);
        $transactions = Model_Transaction::getList($cardId, $contractId, ['limit' => 20]);
        $settings = Model_Card::getCardLimitSettings($cardId);
        $cardInfo = Model_Card::getCardInfo($cardId, $contractId);

		$servicesList = Listing::getServicesForCardLimits([
		    'TUBE_ID' => $card['TUBE_ID']
        ]);

		$popupCardHolderEdit = Form::popup('Редактирование держателя карты', 'card/edit_holder', [
            'card' 				=> $card,
		], 'card_edit_holder_'.$cardId);
        $popupCardLimitsEdit = Form::popupXLarge('Редактирование лимитов карты', 'card/edit_limits', [
            'card' 				=> $card,
            'oilRestrictions' 	=> $oilRestrictions,
            'servicesList'		=> $servicesList,
            'settings'		    => $settings,
        ], 'card_edit_limits_'.$cardId);

        $html = View::factory('ajax/clients/card')
            ->bind('card', $card)
            ->bind('oilRestrictions', $oilRestrictions)
            ->bind('transactions', $transactions)
            ->bind('cardInfo', $cardInfo)
            ->bind('popupCardHolderEdit', $popupCardHolderEdit)
            ->bind('popupCardLimitsEdit', $popupCardLimitsEdit)
        ;

        $this->html($html);
    }

	/**
	 * добавление нового клиента
	 */
	public function action_clientAdd()
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
	 */
	public function action_contractAdd()
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
     * добавляем новые карты
	 */
    public function action_cardsAdd()
	{
		$params = $this->request->post('params');

        $cards = !empty($params['cards']) ? $params['cards'] : [];
        $cardsList = !empty($params['cards_list']) ? $params['cards_list'] : [];

        if (!empty($cardsList)) {
            $cardsList = array_filter(explode("\n", preg_replace("/[^\d\n]/", '', $cardsList)));

            $cards = array_merge($cards, $cardsList);
        }

        $return = [];
        $globalResult = true;

        foreach ($cards as $card) {
            $params['card_id'] = $card;
            $result = Model_Card::editCard($params, Model_Card::CARD_ACTION_ADD);

            if ($result !== true) {
                $globalResult = false;

                $error = '';
                switch ($result) {
                    case Oracle::CODE_ERROR :
                        $error = 'Ошибка';
                        break;
                    case Oracle::CODE_ERROR_EXISTS:
                        $error = 'Карта уже существует';
                        break;
                    case 3:
                        $error = 'Неверный номер карты';
                        break;
                }

                $return[] = ['card' => $card, 'error' => $error];
            }
        }

        $this->jsonResult($globalResult, $return);
	}
    /**
     * редактирование лимитов карты
     */
    public function action_cardEditLimits()
    {
        $cardId     = $this->request->post('card_id');
        $contractId = $this->request->post('contract_id');
        $limits     = $this->request->post('limits') ?: [];

        list($result, $error) = Model_Card::editCardLimits($cardId, $contractId, $limits);

        $this->jsonResult($result, $error);
    }

	/**
	 * редактирование карты
	 */
	public function action_cardEditHolder()
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
	public function action_contractPaymentAdd()
	{
        $payments = [$this->request->post('params')];
		$multi = $this->request->post('multi') ?: 0;
        $message = '';

		if(!empty($multi)){
            $payments = (array)$this->request->post('payments');
        }

        foreach($payments as $payment){
            $payment['date_format'] = $multi ? Date::$dateFormatRu : Date::$dateFormatDefault;
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
	public function action_contractPaymentDelete()
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
	public function action_cardToggle()
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
	public function action_cardOperationsHistory()
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
	public function action_accountPaymentsHistory()
	{
		$contractId = $this->request->param('id');
		$params = [
			'offset' 		=> $this->request->post('offset'),
			'pagination'	=> true,
			'contract_id'	=> $contractId,
		];

		list($paymentsHistory, $more) = Model_Contract::getPaymentsHistory($params);

		if(empty($paymentsHistory)){
			$this->jsonResult(false);
		}

		foreach ($paymentsHistory as &$elem) {
		    $elem['PAY_COMMENT'] = Text::parseUrl($elem['PAY_COMMENT']);
        }

		$this->jsonResult(true, ['items' => $paymentsHistory, 'more' => $more]);
	}

	/**
	 * создание ЛК для пользователя
	 */
	public function action_cabinetCreate()
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
	public function action_cardWithdraw()
	{
		$params = $this->request->post('params');

		$result = Model_Card::withdrawCard($params);

		if(empty($result)){
			$this->jsonResult(false);
		}

		$this->jsonResult(true);
	}

	/**
	 * список состояний контракта
	 */
	public function action_contractHistory()
	{
		if($this->isPost()) {
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
	public function action_addBill()
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
    public function action_editContractNotices()
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
    public function action_billsList()
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
    public function action_cardsList()
    {
        $contractId = $this->request->query('contract_id');

        $params = [
            'CONTRACT_ID'   => $contractId,
            'offset' 		=> $this->request->post('offset'),
            'pagination'	=> true,
            'limit'	        => 20,
            'query'	        => $this->request->post('query'),
            'status'	    => $this->request->post('status'),
            'sort'	        => $this->request->post('sort'),
            'sortWay'       => $this->request->post('sortWay'),
        ];

        list($cards, $more) = Model_Card::getCards($contractId, false, $params);

        if(empty($cards)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true, ['items' => $cards, 'more' => $more]);
    }

    /**
     * редактируем логин пользователя
     */
    public function action_editLogin()
    {
        $login = $this->request->post('login');
        $managerId = $this->request->post('manager_id') ?: User::id();

        $result = Model_Manager::editLogin($managerId, $login);

        if (!empty($result['error'])) {
            $this->jsonResult(false, $result);
        }
        $this->jsonResult(true, $result);
    }

    /**
     * редактирование лимитов договора
     */
    public function action_contractLimitsEdit()
    {
        $limits = $this->request->post('limits');
        $contractId = $this->request->post('contract_id');
        $recalc = $this->request->post('recalc');

        $result = Model_Contract::editLimits($contractId, $limits, $recalc);

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
    public function action_contractIncreaseLimit()
    {
        $amount = $this->request->post('amount');
        $limitId = $this->request->post('limit_id');

        $result = Model_Contract::editLimit($limitId, $amount);

        if(empty($result)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true, $result);
    }

    /**
     * отрисовываем блок продукта для выставления счета
     */
    public function action_addBillProductTemplate()
    {
        $iteration = $this->request->post('iteration');

        $html = View::factory('ajax/clients/add_bill/product')
            ->bind('iteration', $iteration)
        ;

        $this->html($html);
    }

    /**
     * рендер шаблона лимита
     */
    public function action_cardLimitTemplate()
    {
        $cardId     = $this->request->query('cardId');
        $postfix    = $this->request->query('postfix');

        $html = Form::buildLimit($cardId, [], $postfix);

        $this->html($html);
    }

    /**
     * рендер шаблона сервиса лимита
     */
    public function action_cardLimitServiceTemplate()
    {
        $cardId         = $this->request->query('cardId');
        $postfix        = $this->request->query('postfix');

        $html = Form::buildLimitService($cardId, [], $postfix);

        $this->html($html);
    }

    /**
     * удаление клиента
     */
    public function action_clientDelete()
    {
        $clientId = $this->request->post('client_id');

        $result = Model_Client::changeState($clientId, Model_Client::STATE_CLIENT_DELETED);

        if(empty($result)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true);
    }

    /**
     * редактирование тарифа по договору
     */
    public function action_contractTariffEdit()
    {
        $contractId = $this->request->post('contract_id');
        $tariffId = $this->request->post('tariff_id');
        $dateFrom = $this->request->post('date_from');

        $result = Model_Contract::editTariff($tariffId, $contractId, $dateFrom);

        if(empty($result)){
            $this->jsonResult(false);
        }

        $this->jsonResult(true);
    }

    /**
     * получаем историю редактирование тарифа
     */
    public function action_getContractTariffChangeHistory()
    {
        $contractId = $this->request->post('contract_id');

        $params = [
            'contract_id'   => $contractId,
            'offset' 		=> $this->request->post('offset'),
            'pagination'	=> true,
        ];

        list($items, $more) = Model_Contract::getContractTariffChangeHistory($contractId, $params);

        if (empty($items)) {
            $this->jsonResult(false);
        }

        $this->jsonResult(true, ['items' => $items, 'more' => $more]);
    }

    /**
     * с помощью сервиса "ЗаЧестныйБизнес" подгружаем инфу по компании
     */
    public function action_clientLoadInfoByInn()
    {
        $inn = $this->request->post('inn');
        $bik = $this->request->post('bik');

        $data = Model_Client::loadInfoByInn($inn, $bik);

        if (empty($data)) {
            $this->jsonResult(false);
        }

        $this->jsonResult(true, $data);
    }
}