<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class for simple use API ZACHESTNYIBIZNES with PHP
 * Documentation available at https://zachestnyibiznesapi.ru
 */
class Zachestnyibiznes
{
    /**
     * Base API URL for module "paid"
     */
    const
        BASE_URL = 'https://zachestnyibiznesapi.ru/paid/data/';

    /**
     * User's api key
     */
    private $_apikey;

    public function __construct($config = [])
    {
        $config = $config ?: Kohana::$config->load('config');

        $this->_apikey = $config['zachestnyibiznes_apiKey'];
    }

    /**
     * Request to API URL
     * 1) Set context for request
     * 2) Decode answer(JSON) to array
     * @param   string $method method from API documentation
     * @param   array $query user's parameters
     * @return  array           answer from API
     */
    private function _request($method, $query)
    {
        $context = stream_context_create($this->_getParams($query));

        return json_decode(file_get_contents(self::BASE_URL . $method, false, $context), true);
    }

    /**
     * Bringing the parameters to the query string
     * 1) Set base parameters for POST request's context
     * 2) Add user's with needle parameters to POST request's context
     * @param   array $query user's parameters
     * @return  array   $context    correct array of parameters for POST request's context
     */
    private function _getParams($query)
    {
        $context = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
            ],
        ];
        $context['http']['content'] = http_build_query(array_merge($query, [
            'api_key' => $this->_apikey,
            '_format' => 'json',
        ]));

        return $context;
    }

    /**
     * получение данный по компании по ИНН
     *
     * @param $inn
     */
    public function card($inn)
    {
        if (empty($inn)) {
            return false;
        }

        $response = $this->_request('card', ['id' => trim($inn)]);

        if (!empty($response['status']) && $response['status'] == 200) {
            return $response['body']['docs'][0];
        }

        return false;
    }

    /**
     * получение реквизитов компании по ИНН и БИК
     *
     * @param $inn
     */
    public function requisites($inn, $bik)
    {
        if (empty($inn) || empty($bik)) {
            return false;
        }

        $response = $this->_request('requisites', ['id' => trim($inn), 'bik' => trim($bik)]);

        if (!empty($response['status']) && $response['status'] == 200) {
            return $response['body'];
        }

        return false;
    }
}