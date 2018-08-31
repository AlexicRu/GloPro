<?php defined('SYSPATH') or die('No direct script access');

return [
    'dashboard' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            ['click .menu_item_clients' => 'Посмотреть список закрепленных фирм']
        ]
    ],
    'clients' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            [
                'selector' => '.client:first [toggle]',
                'event' => 'click',
                'description' => 'Посмотреть список закрепленных фирм'
            ],
            [
                'selector' => '.client:first tr:first a',
                'event' => 'click',
                'description' => 'Открыть реквизиты договора'
            ]
        ]
    ],
    'contract' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            ['next [ajax_tab="contract"]' => 'Настроки договора'],
            ['click [ajax_tab="cards"]' => 'Список карт, закрепленных за договором']
        ]
    ],
    'cards' => [
        'roles' => [Access::ROLE_ROOT],//array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .ajax_block_cards_list_out' => 'Полный список карт'],
            ['click [ajax_tab="account"]' => 'Данные по лицевому счету договора']
        ]
    ],
    'account' => [
        'roles' => [Access::ROLE_ROOT],//array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .webtour-account' => 'Баланс по договору, платежи и обороты'],
            ['click [ajax_tab="reports"]' => 'Построить отчеты']
        ]
    ],
    'reports' => [
        'roles' => [Access::ROLE_ROOT],//array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .webtour-reports' => 'Выбрать шаблон, дату, формат и сформировать'],
            ['click .webtour-profile' => 'Настройки пользователя'],
            [
                'click .webtour-setting' => 'Настройки пользователя',
                'showNext' => false,
                'skipButton' => ['text' => "End"]
            ],
        ]
    ],
];