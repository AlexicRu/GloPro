<?php defined('SYSPATH') or die('No direct script access');

return array(
    'clients'           => ['title' => 'Фирмы', 'icon' => 'icon-clients'],
    'control'           => ['title' => 'Управление', 'icon' => 'icon-set', 'children' => [
        'managers'      => 'Менеджеры',
        'dots'          => 'Точки обслуживания',
        'tariffs'       => 'Тарифы',
        'connect_1c'    => 'Связь с 1С',
        'cards_groups'  => 'Группы карт',
        'suppliers'     => 'Поставщики',
    ]],
    'administration'    => ['title' => 'Сервис', 'icon' => 'icon-set', 'children' => [
        'transactions'  => 'Транзакции'
    ]],
    'reports'           => ['title' => 'Отчетность', 'icon' => 'icon-reports'],
    'news'              => ['title' => 'Новости', 'icon' => 'icon-news'],
    'support'           => ['title' => 'Поддержка', 'icon' => 'icon-question'],
);