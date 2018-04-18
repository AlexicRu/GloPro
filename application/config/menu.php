<?php defined('SYSPATH') or die('No direct script access');

return array(
    'clients'           => ['title' => 'Фирмы', 'icon' => 'fal fa-users'],
    'suppliers'         => ['title' => 'Поставщики', 'icon' => 'fal fa-tint'],
    'reports'           => ['title' => 'Отчетность', 'icon' => 'fal fa-file-alt'],
    'control'           => ['title' => 'Управление', 'icon' => 'fal fa-cogs', 'children' => [
        'managers'      => 'Менеджеры',
        'tariffs'       => 'Тарифы',
        '1c-connect'    => 'Связь с 1С',
        'cards-groups'  => 'Группы карт',
        'firms-groups'  => 'Группы фирм',
        'dots-groups'   => 'Группы ТО',
    ]],
    'references'        => ['title' => 'Справочники', 'icon' => 'fal fa-clipboard-list', 'children' => [
        'sources'       => 'Источники данных',
        'addresses'     => 'Адреса',
        'currency'      => 'Валюты',
        'services'      => 'Услуги',
        'cards'         => 'Список карт',
        'dots'          => 'Точки обслуживания',
    ]],
    'administration'    => ['title' => 'Сервис', 'icon' => 'fal fa-sitemap', 'children' => [
        'transactions'      => 'Транзакции',
        'calc-tariffs'      => 'Расчет тарифов',
        'cards-transfer'    => 'Перенос карт'
    ]],
    'news'              => ['title' => 'Новости', 'icon' => 'fal fa-bullhorn'],
    'support'           => ['title' => 'Поддержка', 'icon' => 'fal fa-question-circle'],
    'system'            => ['title' => 'System', 'icon' => 'fal fa-server', 'children' => [
        'deploy'        => 'Deploy',
        'db'            => 'DB',
    ]],
);