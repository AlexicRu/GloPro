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
                    $documents[] = $workflow; //Добавляем в массив документов новый документ
                }
            }
        }

        $this->documents = $documents; // Передаем массив документов в Свойство класса
    }

    function getDocs()
    {
        return $this->documents; // Отдаем документы по запросу
    }
}