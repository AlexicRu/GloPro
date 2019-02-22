<?php defined('SYSPATH') or die('No direct script access');

return [
    'dashboard' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            [
                'selector' => '.sidebar-nav .menu_item_clients',
                'event' => 'click',
                'description' => 'Посмотреть список закрепленных фирм'
            ]
        ]
    ],
    'clients' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            [
                'selector' => '.webtour-toggle:first',
                'event' => 'click',
                'description' => 'Посмотреть список закрепленных фирм'
            ],
            [
                'selector' => '.webtour-elem:visible:first',
                'event' => 'click',
                'description' => 'Открыть реквизиты договора'
            ]
        ]
    ],
    'contract' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .webtour-contract' => 'Настроки договора'],
            ['click .webtour-cards' => 'Список карт, закрепленных за договором']
        ]
    ],
    'cards' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .webtour-cards-list:visible' => 'Полный список карт'],
            ['click .webtour-account' => 'Данные по лицевому счету договора']
        ]
    ],
    'account' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .webtour-account-block' => 'Баланс по договору, платежи и обороты'],
            ['click .webtour-reports' => 'Построить отчеты']
        ]
    ],
    'reports' => [
        'roles' => array_keys(Access::$clientRoles),
        'scenario' => [
            ['next .webtour-reports' => 'Выбрать шаблон, дату, формат и сформировать'],
            ['click .webtour-profile' => 'Настройки пользователя'],
            [
                'click .webtour-settings' => 'Настройки пользователя',
                'timeout' => 1000,
                'showNext' => false,
                'skipButton' => ['text' => "End"]
            ],
        ]
    ],
];