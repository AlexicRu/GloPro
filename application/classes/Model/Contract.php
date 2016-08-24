<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contract extends Model
{
    const STATE_CONTRACT_WORK 			= 1;
    const STATE_CONTRACT_BLOCKED 		= 9;
    const STATE_CONTRACT_EXPIRED 		= 5;
    const STATE_CONTRACT_NOT_IN_WORK 	= 6;

    public static $statusContractNames = [
        self::STATE_CONTRACT_WORK 			=> 'В работе',
        self::STATE_CONTRACT_NOT_IN_WORK 	=> 'Не в работе',
        self::STATE_CONTRACT_BLOCKED 		=> 'Заблокирован',
        self::STATE_CONTRACT_EXPIRED 		=> 'Завершен',
    ];

    public static $statusContractClasses = [
        self::STATE_CONTRACT_WORK 			=> 'label_success',
        self::STATE_CONTRACT_NOT_IN_WORK 	=> 'label_info',
        self::STATE_CONTRACT_BLOCKED 		=> 'label_error',
        self::STATE_CONTRACT_EXPIRED 		=> 'label_warning',
    ];

	const DEFAULT_DATE_END				= '31.12.2099';
    const CURRENCY_RUR 		            = 643;

	const PAYMENT_SCHEME_UNLIMITED 		= 1;
	const PAYMENT_SCHEME_PREPAYMENT 	= 2;
	const PAYMENT_SCHEME_LIMIT 			= 3;

	const INVOICE_PERIOD_TYPE_DAY		= 'D';
	const INVOICE_PERIOD_TYPE_MONTH		= 'M';

	const PAYMENT_ACTION_DELETE	= 0;
	const PAYMENT_ACTION_ADD	= 1;
	const PAYMENT_ACTION_EDIT	= 2;

	public static $paymentSchemes = [
		self::PAYMENT_SCHEME_UNLIMITED 	=> 'Безлимит',
		self::PAYMENT_SCHEME_PREPAYMENT => 'Предоплата',
		self::PAYMENT_SCHEME_LIMIT 		=> 'Порог отключения',
	];

	public static $invoicePeriods = [
		self::INVOICE_PERIOD_TYPE_DAY 	=> 'День',
		self::INVOICE_PERIOD_TYPE_MONTH => 'Месяц',
	];

	public static $paymentsActions = [
		self::PAYMENT_ACTION_ADD 	=> 'Добавить платеж',
		self::PAYMENT_ACTION_DELETE => 'Удалить платеж',
		self::PAYMENT_ACTION_EDIT 	=> 'Обновить платеж',
	];

	/**
	 * получаем список контрактов
	 */
	public static function getContracts($clientId = false, $contractId = false)
	{
		if(empty($clientId) && empty($contractId)){
			return [];
		}

		$db = Oracle::init();

		$sql = "
			select *
			from ".Oracle::$prefix."V_WEB_CL_CONTRACTS
			where 1=1
		";

		if(!empty($clientId)){
			$sql .= " and client_id = ".Oracle::quote($clientId);
		}

		if(!empty($contractId)){
			$sql .= " and contract_id = ".Oracle::quote($contractId);
		}

		$sql .= 'order by date_begin, state_id';

		$contracts = $db->query($sql);

		return $contracts;
	}

	/**
	 * получаем контракт по его id
	 *
	 * @param $contractId
	 */
	public static function getContract($contractId)
	{
		$contract = self::getContracts(false, $contractId);

		if(!empty($contractId)){
			return reset($contract);
		}

		return false;
	}

	/**
	 * получаем данные по конретному контраку
	 *
	 * @param $contractId
	 */
	public static function getContractSettings($contractId)
	{
		if(empty($contractId)){
			return [];
		}

		$db = Oracle::init();

		$sql = "
			select *
			from ".Oracle::$prefix."V_WEB_CL_CONTRACTS_SET
			where contract_id = ".Oracle::quote($contractId)
		;

		$contract = $db->row($sql);

		if($contract['AUTOBLOCK_FLAG'] == 0 && $contract['AUTOBLOCK_LIMIT'] == 0){
			$contract['scheme'] = self::PAYMENT_SCHEME_UNLIMITED;
		}elseif($contract['AUTOBLOCK_FLAG'] == 1 && $contract['AUTOBLOCK_LIMIT'] == 0){
			$contract['scheme'] = self::PAYMENT_SCHEME_PREPAYMENT;
		}else{
			$contract['scheme'] = self::PAYMENT_SCHEME_LIMIT;
		}

		return $contract;
	}

	/**
	 * баланс и оборот по контракту
	 *
	 * @param $contractId
	 */
	public static function getContractBalance($contractId)
	{
		if(empty($contractId)){
			return [];
		}

		$db = Oracle::init();

		$sql = "
			select *
			from ".Oracle::$prefix."V_WEB_CTR_BALANCE
			where contract_id = ".Oracle::quote($contractId)
		;

		$balance = $db->row($sql);

		return $balance;
	}

	/**
	 * редактируем данные по контракту
	 *
	 * @param $contractId
	 * @param $params
	 * todo переделать
	 */
	public static function editContract($contractId, $params)
	{
		if(
			empty($contractId) ||
			empty($params['contract']['CONTRACT_NAME'])
		){
			return false;
		}

		$db = Oracle::init();

        $user = Auth::instance()->get_user();

		$data = [
			'p_contract_id'		=> $contractId,
			'p_contract_name' 	=> $params['contract']['CONTRACT_NAME'],
			'p_date_begin' 		=> $params['contract']['DATE_BEGIN'],
			'p_date_end' 		=> $params['contract']['DATE_END'],
			'p_currency' 		=> self::CURRENCY_RUR,
			'p_state_id' 		=> $params['contract']['STATE_ID'],
			'p_manager_id' 		=> $user['MANAGER_ID'],
			'p_error_code' 		=> 'out',
		];

        $data1 = [
            'p_contract_id'		        => $contractId,
            'p_tarif_online' 	        => $params['settings']['TARIF_ONLINE'],
            'p_tarif_offline' 		    => $params['settings']['TARIF_OFFLINE'],
            'p_autoblock_limit' 		=> $params['settings']['AUTOBLOCK_LIMIT'],
            'p_autoblock_flag' 		    => $params['settings']['scheme'] == 1 ? 0 : 1,
            'p_penalties' 		        => $params['settings']['PENALTIES'],
            'p_penalties_flag' 		    => $params['settings']['PENALTIES'] ? 1 : 0,
            'p_overdraft' 		        => abs($params['settings']['OVERDRAFT']),
            'p_invoice_currency' 		=> self::CURRENCY_RUR,
            'p_invoice_period_type' 	=> $params['settings']['INVOICE_PERIOD_TYPE'],
            'p_invoice_period_value' 	=> $params['settings']['INVOICE_PERIOD_VALUE'],
            'p_manager_id' 		        => $user['MANAGER_ID'],
            'p_error_code' 		        => 'out',
        ];

		$res = $db->procedure('client_contract_edit', $data);
		$res1 = $db->procedure('client_contract_settings_edit', $data1);

		if(empty($res) || empty($res1)){
			return true;
		}

		return false;
	}

	/**
	 * Получаем список тарифов
	 */
	public static function getTariffs()
	{
		$db = Oracle::init();

		$user = Auth::instance()->get_user();

		$sql = "select * from ".Oracle::$prefix."v_tarifs_list where manager_id = ".Oracle::quote($user['MANAGER_ID']);

		return $db->query($sql);
	}

	/**
	 * добавление договора к пользователю
	 *
	 * @param $params
	 */
	public static function addContract($params)
	{
		if(empty($params['client_id']) || empty($params['name']) || empty($params['date_start'])){
			return false;
		}

		if(!empty($params['date_end']) && strtotime($params['date_start']) > strtotime($params['date_end'])) {
			return ['error' => 'Дата начала не может быть позже даты окончания'];
		}

		$db = Oracle::init();

		$user = Auth::instance()->get_user();

		$data = [
			'p_client_id' 		=> $params['client_id'],
			'p_contract_name' 	=> $params['name'],
			'p_date_begin' 		=> $params['date_start'],
			'p_date_end' 		=> !empty($params['date_end']) ? $params['date_end'] : self::DEFAULT_DATE_END,
			'p_currency' 		=> self::CURRENCY_RUR,
			'p_manager_id' 		=> $user['MANAGER_ID'],
			'p_contract_id' 	=> 'out',
			'p_error_code' 		=> 'out',
		];

		$res = $db->procedure('client_contract_add', $data);

		if(empty($res)){
			return true;
		}

		return false;
	}

	/**
	 * получить историю операций по контракту
	 *
	 * @param $cardId
	 * @param $limit
	 */
	public static function getPaymentsHistory($contractId, $params = [])
	{
		if(empty($contractId)){
			return [];
		}

		$db = Oracle::init();

		$sql = "
			select *
			from ".Oracle::$prefix."V_WEB_CL_CONTRACTS_PAYS
			where 1=1
		";

		if(!empty($contractId)){
			$sql .= " and contract_id = '".Oracle::quote($contractId)."'";
		}

		$sql .= " order by O_DATE desc";

		if(!empty($params['pagination'])) {
			return $db->pagination($sql, $params);
		}

		return $db->query($sql);
	}

	/**
	 * добавление нового платежа к
	 *
	 * @param $action
	 * @param $params
	 */
	public static function payment($action, $params)
	{
		if(!in_array($action, array_keys(self::$paymentsActions)) || empty($params['contract_id'])){
			return false;
		}

		$db = Oracle::init();

		$user = Auth::instance()->get_user();

		$data = [
			'p_contract_id' 	=> $params['contract_id'],
			'p_action' 			=> $action,
			'p_order_guid' 		=> $action != self::PAYMENT_ACTION_ADD ? $params['guid'] : null,
			'p_order_num' 		=> $action == self::PAYMENT_ACTION_ADD ? $params['num'] : null,
			'p_order_date' 		=> $action == self::PAYMENT_ACTION_ADD ? $params['date'] : null,
			'p_value' 			=> $action != self::PAYMENT_ACTION_DELETE ? Oracle::toFloat($params['value']) : 0,
			'p_payment_cur' 	=> $action == self::PAYMENT_ACTION_ADD ? self::CURRENCY_RUR : null,
			'p_comment' 		=> $action == self::PAYMENT_ACTION_ADD ? $params['comment'] : null,
			'p_manager_id' 		=> $user['MANAGER_ID'],
			'p_error_code' 		=> 'out',
		];

		$res = $db->procedure('client_contract_payment', $data);

		if(empty($res)){
			return true;
		}

		return false;
	}

	/**
	 * Обороты по договору
	 *
	 * @param $contractId
	 */
	public static function getTurnover($contractId)
	{
		if(empty($contractId)){
			return [];
		}

		$db = Oracle::init();

		$sql = "
			select *
			from ".Oracle::$prefix."V_WEB_CTR_BALANCE
			where 1=1
		";

		if(!empty($contractId)){
			$sql .= " and contract_id = '".Oracle::quote($contractId)."'";
		}

		$turnover = $db->row($sql);

		return $turnover;
	}

	/**
	 * получаем историю по контракту
	 *
	 * @param $params
	 */
	public static function getHistory($params)
	{
		if(empty($params['contract_id'])){
			return false;
		}

		$db = Oracle::init();

		$sql = "select * from ".Oracle::$prefix."v_web_cl_contract_history where contract_id = ".$params['contract_id']. ' order by history_date desc';

		if(!empty($params['pagination'])) {
			return $db->pagination($sql, $params);
		}

		return $db->query($sql);
	}

    /**
     * добавление нового платежа к
     *
     * @param $contractId
     * @param $sum
     */
    public static function addBill($contractId, $sum)
    {
        if(empty($contractId) || empty($sum)){
            return false;
        }

        $db = Oracle::init();

        $data = [
            'p_contract_id' 	=> $contractId,
            'p_invoice_sum' 	=> str_replace(',', '.', $sum),
            'p_invoice_num' 	=> 'out',
        ];

        $invoiceNum = $db->procedure('client_contract_invoice_pay', $data, true);

        return $invoiceNum['p_invoice_num'];
    }

    /**
     * редактирование настройек уведомлений
     *
     * @param $contractId
     * @param $params
     */
    public static function editNoticesSettings($contractId, $params)
    {
        if(empty($contractId)){
            return Oracle::CODE_ERROR;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        $data = [
            'p_contract_id'         => $contractId,
            'p_manager_id'          => $user['MANAGER_ID'],
            'p_report_send'         => 0,
            'p_rep_send_per'        => 'W',
            'p_rep_send_per_value'  => 0,
            'p_eml_card_block'      => !empty($params['notice_email_card']) ? 1 : 0,
            'p_eml_contract_block'  => !empty($params['notice_email_firm']) ? 1 : 0,
            'p_eml_blnc_ctrl'       => !empty($params['notice_email_barrier']) ? 1 : 0,
            'p_eml_blnc_ctrl_value' => !empty($params['notice_email_barrier_value']) ? $params['notice_email_barrier_value'] : 0,
            'p_sms_card_block'      => 0,
            'p_sms_contract_block'  => 0,
            'p_sms_blnc_ctrl'       => 0,
            'p_sms_blnc_ctrl_value' => 0,
            'p_sms_add_payment'     => 0,
            'p_sms_card_trz'        => 0,
            'p_error_code' 		    => 'out',
        ];

        return $db->procedure('client_contract_notify_config', $data);
    }

    /**
     * получаем тукущие настройки уведомлений
     *
     * @param $contractId
     */
    public static function getContractNoticeSettings($contractId)
    {
        if(empty($contractId)){
            return false;
        }

        $db = Oracle::init();

        $user = Auth::instance()->get_user();

        $sql = "select * from ".Oracle::$prefix."V_WEB_CTR_NOTIFY_SET where contract_id = ".$contractId. " and manager_id = ".$user['MANAGER_ID'];

        return $db->row($sql);
    }
}