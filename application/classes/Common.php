<?php defined('SYSPATH') or die('No direct script access.');

class Common
{
    const CURRENCY_RUR 		    = 643;
    const NEW_DESIGN_FOLDER     = 'admin-pro';
    const DESIGN_DEFAULT        = 'glopro';

    /**
     * favicon
     */
    public static function getFaviconRawData($customView = '')
    {
        switch ($customView) {
            case 'gpn':
            case 'binoil':
                $favicon = '<link type="image/x-icon" href="'. Common::getAssetsLink() .'img/projects/'. $customView .'/favicon.ico" rel="icon">';
                break;
            default:
                $favicon = '<link type="image/x-icon" href="'. Common::getAssetsLink() .'img/projects/'. self::DESIGN_DEFAULT .'/favicon.ico" rel="icon">';
                //$favicon = '<link rel="icon" type="image/png" href="/assets/favicon/favicon-16x16.png" sizes="16x16">';
            }

        return $favicon;
    }

    /**
     * @return bool
     */
    public static function isProd()
    {
        if (Kohana::$environment == Kohana::PRODUCTION) {
            return true;
        }
        return false;
    }

    /**
     * получаем конфиг для текущего состояния
     */
    public static function getEnvironmentConfig()
    {
        $state = 'dev';

        if (self::isProd()) {
            $state = 'prod';
        }

        return Kohana::$config->load($state);
    }

    public static function stringFromKeyValueFromArray($array, $delimiter = '<br>')
    {
        $result = [];

        foreach ($array as $key => $value) {
            $result[] = $key . ' - ' . $value;
        }

        return implode($delimiter, $result);
    }

    /**
     * получаем версию продукта

     */
    public static function getVersion($asProd = false)
    {
        $config = Kohana::$config->load('version');

        return self::isProd() || $asProd ? $config['hash'] : time();
    }

    /**
     * добавляем js для подключения в шапку
     *
     * @param $file
     */
    public static function addJs($file)
    {
        $js = (array)(new View())->js;

        View::set_global('js', array_merge($js, [Common::getAssetsLink() . 'js/' . $file]));
    }

    /**
     * добавляем css для подключения в шапку
     *
     * @param $file
     */
    public static function addCss($file)
    {
        $css = (array)(new View())->css;

        View::set_global('css', array_merge($css, [Common::getAssetsLink() . 'css/' . $file]));
    }

    public static function getAdminProAssetsLink()
    {
        return self::getAssetsLink(self::NEW_DESIGN_FOLDER);
    }

    /**
     * получаем ссылку на файлы
     *
     * @param $type
     * @return string
     */
    public static function getAssetsLink($type = '')
    {
        if ($type == self::NEW_DESIGN_FOLDER) {
            return self::isProd() ? '/'. self::NEW_DESIGN_FOLDER .'/build/' : '/'. self::NEW_DESIGN_FOLDER .'/';
        }
        return self::isProd() ? '/assets/build/' : '/assets/';
    }

    /**
     * шифруем
     *
     * @param $plaintext
     * @return string
     * @throws Kohana_Exception
     */
    public static function encrypt($plaintext)
    {
        $key            = Kohana::$config->load('config')['salt'];
        $ivlen          = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv             = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac           = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext     = base64_encode( $iv.$hmac.$ciphertext_raw );

        return str_replace(array('+', '/'), array('-', '_'), $ciphertext);
    }

    /**
     * дешифруем
     *
     * @param $ciphertext
     * @return string
     * @throws Kohana_Exception
     */
    public static function decrypt($ciphertext)
    {
        $key                = Kohana::$config->load('config')['salt'];
        $c                  = base64_decode(str_replace(array('-', '_'), array('+', '/'), $ciphertext));
        $ivlen              = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv                 = substr($c, 0, $ivlen);
        $hmac               = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw     = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac            = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);

        //с PHP 5.6+ сравнение, не подверженное атаке по времени
        return hash_equals($hmac, $calcmac) ? $original_plaintext : '';
    }

    /**
     * строим дерево
     *
     * @param $result
     * @param $field
     * @param bool $noArray
     * @param bool $subField
     * @return array
     */
    public static function buildTreeFromDBResult($result, $field, $noArray = false, $subField = false)
    {
        $return = [];

        if(!empty($result)){
            $check = reset($result);

            if(!isset($check[$field])){
                return $return;
            }

            foreach($result as $row){
                if($noArray) {
                    $return[$row[$field]] = !empty($subField) ? $row[$subField] : $row;
                }else{
                    $return[$row[$field]][] =  !empty($subField) ? $row[$subField] : $row;
                }
            }
        }

        return $return;
    }
}