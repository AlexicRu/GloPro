<?php defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date
{
    const DATE_MAX = '31.12.2099';
    const DATE_MAX_DEFAULT = '2099-12-31';

    public static $dateFormatRu = 'd.m.Y';
    public static $dateFormatDefault = 'Y-m-d';

    public static function monthRu($month = false, $type = 1)
    {
		$months = array(
			1 => 'Январь',
			2 => 'Февраль',
			3 => 'Март',
			4 => 'Апрель',
			5 => 'Май',
			6 => 'Июнь',
			7 => 'Июль',
			8 => 'Август',
			9 => 'Сентябрь',
			10 => 'Октябрь',
			11 => 'Ноябрь',
			12 => 'Декабрь',
		);
		
		if($type == 2){
			$months = array(
				1 => 'января',
				2 => 'февраля',
				3 => 'марта',
				4 => 'апреля',
				5 => 'мая',
				6 => 'июня',
				7 => 'июля',
				8 => 'августа',
				9 => 'сентября',
				10 => 'октября',
				11 => 'ноября',
				12 => 'декабря',
			);	
		}		
		
        $month = $month ?: date("n", time());
		
        return $months[$month];
    }

    /**
     * немного махинаций с датами, пытаемся угадать, что же нам пришло, так как excel присылает что попало
     *
     * @param $dateStr
     * @param $exportFormat
     * @return string
     */
    public static function guessDate($dateStr, $exportFormat = 'd.m.Y')
    {
        $dateTimeArr = explode(' ', $dateStr);
        $dateStr = array_shift($dateTimeArr);

        $delimiter = strpos($dateStr, '-') !== false ? '-' : (strpos($dateStr, '/') !== false ? '/' : '.');
        $dateArr = explode($delimiter, $dateStr);
        $format = "d{$delimiter}m{$delimiter}y";

        if (count($dateArr) == 3) {
            if (strlen($dateArr[0]) == 4) {
                $format = "Y{$delimiter}m{$delimiter}d";
            } else if (strlen($dateArr[2]) == 4) {
                $format = "d{$delimiter}m{$delimiter}Y";
            } else {
                //y-m-d
                $year = date('y');
                if ($dateArr[0] == $year && $dateArr[2] != $year) {
                    $format = "y{$delimiter}m{$delimiter}d";
                }
            }
        }

        $date = DateTime::createFromFormat($format, $dateStr);

        return $date->format($exportFormat);
    }

    public static function dateDifference($date_1 , $date_2 , $format = false)
    {
        if (empty($format)) {
            $format = self::$dateFormatDefault;
        }
        $datetime1 = DateTime::createFromFormat($format, $date_1);
        $datetime2 = DateTime::createFromFormat($format, $date_2);

        return $datetime1->getTimestamp() - $datetime2->getTimestamp();
    }

    /**
     * Returns a date/time string with the specified timestamp format
     *
     *     $time = Date::format('5 minutes ago');
     *
     * @link    http://www.php.net/manual/datetime.construct
     * @param   string  $datetime       datetime string
     * @param   string  $formatFrom
     * @param   string  $formatTo
     * @return  string
     */
    public static function format($datetime = 'now', $formatFrom = false, $formatTo = false)
    {
        $formatFrom = !$formatFrom ? self::$dateFormatDefault : $formatFrom;
        $formatTo = !$formatTo ? self::$dateFormatRu : $formatTo;

        $dt = DateTime::createFromFormat($formatFrom, $datetime);

        return $dt->format($formatTo);
    }

    public static function formatToDefault($datetime = 'now')
    {
        return self::format($datetime, self::$dateFormatRu, self::$dateFormatDefault);
    }
}
