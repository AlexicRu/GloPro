<?php defined('SYSPATH') or die('No direct script access');

return array(
    'dashboard'         => ['title' => 'Dashboard', 'icon' => 'fa-fw fal fa-tachometer-alt', 'children' => [
        'index'         => 'Фирмы',
        'agent'         => 'Дистрибьюторы',
    ]],
    'info'              => ['title' => 'Инфо-портал', 'icon' => 'fa-fw fal fa-info', 'children' => [
        'index'         => 'Информация',
        'marketing'     => 'РИМ',
        'passports'     => 'Паспорта качества',
    ]],
    'clients'           => ['title' => 'Фирмы', 'icon' => 'fa-fw fal fa-users'],
    'suppliers'         => ['title' => 'Поставщики', 'icon' => 'fa-fw fal fa-tint'],
    'reports'           => ['title' => 'Отчетность', 'icon' => 'fa-fw fal fa-file-alt'],
    'control'           => ['title' => 'Управление', 'icon' => 'fa-fw fal fa-cogs', 'children' => [
        'managers'      => 'Менеджеры',
        'tariffs'       => 'Тарифы',
        '1c-connect'    => 'Связь с 1С',
        'cards-groups'  => 'Группы карт',
        'firms-groups'  => 'Группы фирм',
        'dots-groups'   => 'Группы ТО',
    ]],
    'references'        => ['title' => 'Справочники', 'icon' => 'fa-fw fal fa-clipboard-list', 'children' => [
        'sources'       => 'Источники данных',
        'addresses'     => 'Адреса',
        'currency'      => 'Валюты',
        'services'      => 'Услуги',
        'cards'         => 'Список карт',
        'dots'          => 'Точки обслуживания',
    ]],
    'administration'    => ['title' => 'Сервис', 'icon' => 'fa-fw fal fa-sitemap', 'children' => [
        'transactions'      => 'Транзакции',
        'calc-tariffs'      => 'Расчет тарифов',
        'cards-transfer'    => 'Перенос карт'
    ]],
    'news'              => ['title' => 'Новости', 'icon' => 'fa-fw fal fa-bullhorn'],
    'support'           => ['title' => 'Поддержка', 'icon' => 'fa-fw fal fa-question-circle'],
    'system'            => ['title' => 'System', 'icon' => 'fa-fw fal fa-puzzle-piece', 'children' => [
        'deploy'        => 'Deploy',
        'db'            => 'DB',
    ]],
);