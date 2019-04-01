<?php defined('SYSPATH') or die('No direct script access.');

class Model_Parser_BankStatement extends Model
{
    protected $documents; // Свойство для хранения "отпарсенных" документов

    //Конструктор принимает на вход путь к файлу
    function __construct($maas)
    {
        //$maas = file($fileaddr); // Открываем файл как массив строк
        $documents = []; // Создаем пустой массив для хранения документов

        foreach ($maas as $key => $result) { //Начинаем парсить каждую строку
            //$value2 = rtrim($value); // Тримируем правую сторону строки от управляющих символов
            //$value2 = mb_convert_encoding($value2, "utf-8", "windows-1251"); // Конвертируем значение в utf-8 так как изначальная кодировка файла windows-1251
            //$result = explode('=', $value2); // Разбиваем строку на Ключ => Значение

            if (count($result) == 2) { // Проверяем прошла ли разбивка
                if ($result[0] == 'СекцияДокумент') { //Если разбивка прошла и ключ результата СекцияДокумент то
                    $workflow = new Model_Parser_BankStatementDocument(); //Создаем новый Объект
                }

                if (isset($workflow)) { //Если объект создан то
                    $workflow->set($result[0], $result[1]); // Назначаем Свойство, Содержимое
                }
            } else { //Если разбивка не прошла
                if ($result[0] == 'КонецДокумента') { //То проверяем конец ли это документа

                    if (!empty($workflow) && $workflow->doctype == 'Платежное поручение') {
                        $documents[] = $workflow; //Добавляем в массив документов новый документ
                    }
                }
            }
        }

        $this->documents = $documents; // Передаем массив документов в Свойство класса
    }

    function getDocs()
    {
        return $this->documents; // Отдаем документы по запросу
    }

    /**
     * достаем данные из транзакций
     */
    function getTransactions()
    {
        /*
В данной выписке будет отсутствовать ID договора, идентифицировать контракт нужно по ключу ИНН из поля "ПлательщикИНН" + "ПлательщикКПП" (если ИПшник, КПП будет пустой) и номер договора из поля НазначениеПлатежа (пример поля: "Перечисляется предоплата по договору поставки № 185ГПН/16 от 27.01.16 товар. В том числе НДС 28983.05", нужно находить номер "185ГПН/16" ).

Нюансы:
2) ПлательщикИНН не должен совпадать с ИНН агента, указанного в "Сервис" - "Настройки" - "ИНН Агента"
3) В случае если, ID договора по ключу определить не получилось, дать возможность клиенту самостоятельно выбрать этот договор
а) Если по ИНН найден клиент, выдавать список договоров, закрепленных за данным клиентом
б) Если ИНН не обнаружен, дать возможность клиенту выбрать клиента из списка всех клиентов закрепленных за менеджером, а затем договор этого клиента
4) Даже если все поля в платеже определены, у пользователя все равно должна быть возможность скорректировать выбор клиента и договор
5) В случае, если ID договора не определен, помечать неидентифицированную строку цветом
         */

        $sql = (new Builder())->select()
            ->from('V_WEB_CLIENTS_PROFILE t1')
            ->join('V_WEB_CLIENTS_LIST t2', 't1.client_id = t2.client_id')
            ->where('t2.manager_id = ' . User::id())
            ->whereStart();

        $found = false;

        foreach ($this->documents as $row) {
            $inn = $row->payerinn;
            $kpp = $row->payerkpp;
            $direction = $row->paydirection;

            if (empty($inn)) {
                continue;
            }

            $found = true;

            $sql
                ->whereStart('or')
                ->where('t1.inn = ' . Oracle::quote($inn))
                ->where('t1.kpp = ' . Oracle::quote($kpp))
                ->whereEnd();
        }

        if (!$found) {
            return [];
        }

        $sql->whereEnd();

        $db = Oracle::init();

        $clients = $db->query($sql);

        $clientsIds = array_column($clients, 'CLIENT_ID');

        $contracts = Model_Contract::getContracts([
            'skip_user_contract_check' => true,
            'client_id' => $clientsIds
        ]);

        foreach ($this->documents as $key => &$row) {
            $row->foundClientId = false;
            $row->foundClientName = '<span class="badge badge-danger">Клиент не определен</span>';
            $row->foundContractId = false;
            $row->foundContractName = '<span class="badge badge-danger">Договор не определен</span>';

            foreach ($clients as $client) {
                if ($row->payerinn == $client['INN'] && $row->payerkpp == $client['KPP']) {
                    $row->foundClientId = $client['CLIENT_ID'];
                    $row->foundClientName = $client['NAME'];
                    break;
                }
            }

            if ($row->foundClientId) {
                foreach ($contracts as $contract) {
                    if (strpos($row->paydirection, $contract['CONTRACT_NAME']) !== false) {
                        $row->foundContractId = $contract['CONTRACT_ID'];
                        $row->foundContractName = $contract['CONTRACT_NAME'];
                        break;
                    }
                }
            }

            $row->html = strval(Form::buildField('contract_choose_single', 'contract_choose_single_' . $key, $row->foundContractId, [
                'depend_values' => ['client_id' => $row->foundClientId],
                'depend_postfix' => $key,
                'depend_hidden' => false,
                'colored_empty' => true,
            ]));

            $row->found = /*$row->foundClientName . '<hr>' .*/
                $row->foundContractName;
        }

        return $this->documents;
    }
}