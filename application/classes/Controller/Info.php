<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Info extends Controller_Common
{

    public function before()
    {
        parent::before();

        $this->title[] = 'Информационный портал';
    }

    /**
     * инфо-портал
     */
	public function action_index()
	{
	    $files = [
	        [
	            'title' => 'Материалы для работы через аукционы и конкурсы',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Ppt'],
                        'name'  => 'Презентация 29.10.2018 вебинар',
                        'file'  => '/file/info/Материалы_АиК/Презентация_29.10.2018_вебинар.pptx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Тех. Карта по подготовке ТЗ',
                        'file'  => '/file/info/Материалы_АиК/Тех_Карта_по_подготовке_ТЗ.docx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Ppt'],
                        'name'  => 'Алгоритм действий заказчика при принятии решения об одностороннем отказе',
                        'file'  => '/file/info/Материалы_АиК/Алгоритм_действий_заказчика_при_принятии_решения_об_одностороннем_отказе.pptx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Постановление Правительства РФ от 15.01.2018 N 11',
                        'file'  => '/file/info/Материалы_АиК/Постановление_Правительства_РФ_от_15.01.2018_N_11.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Ppt'],
                        'name'  => 'Презентация (ГОСЗАКАЗ - 2018)',
                        'file'  => '/file/info/Материалы_АиК/Презентация_ГОСЗАКАЗ-2018.pptx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Распоряжение Правительства РФ<br>от 16.01.2018 N 21-р',
                        'file'  => '/file/info/Материалы_АиК/Распоряжение_Правительства_РФ_от_16.01.2018_N_21-р.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Типовое ТЗ помощь клиенту',
                        'file'  => '/file/info/Материалы_АиК/Типовое_ТЗ_помощь_клиенту.docx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Федеральный закон<br>от 29.12.2017 N 475-ФЗ',
                        'file'  => '/file/info/Материалы_АиК/Федеральный_закон_от_29.12.2017_N_475-ФЗ.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Федеральный закон<br>от 31.12.2017 N 496-ФЗ',
                        'file'  => '/file/info/Материалы_АиК/Федеральный_закон_от_31.12.2017_N_496-ФЗ.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Федеральный закон<br>от 31.12.2017 N 504-ФЗ',
                        'file'  => '/file/info/Материалы_АиК/Федеральный_закон_от_31.12.2017_N_504-ФЗ.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Федеральный закон<br>от 31.12.2017 N 505-ФЗ',
                        'file'  => '/file/info/Материалы_АиК/Федеральный_закон_от_31.12.2017_N_505-ФЗ.pdf'
                    ],
                ]
            ],
            [
                'title' => 'API',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Specification VIP API v.1.1.10',
                        'file'  => '/file/info/API/Specification_VIP_API_v.1.1.10.docx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Specification VIP API v.1.1.9',
                        'file'  => '/file/info/API/Specification_VIP_API_v.1.1.9.docx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Specification VIP API v.1.1.8',
                        'file'  => '/file/info/API/Specification_VIP_API_v.1.1.8.docx'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Specification VIP API v.1.1.7',
                        'file'  => '/file/info/API/Specification_VIP_API_v.1.1.7.docx'
                    ],
                ]
            ],
            [
                'title' => 'Мониторинг цен',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Мониторинг цен январь 2019',
                        'file' => '/file/info/Мониторинг_цен/Мониторинг_цен_январь_2019.pdf'
                    ],
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Мониторинг цен ноябрь 2018',
                        'file' => '/file/info/Мониторинг_цен/Мониторинг_цен_ноябрь_2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Price Monitoring 03 08',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_03_08.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Price Monitoring 03 10',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_03_10.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Price Monitoring 05 09',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_05_09.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Мониторинг цен за сентябрь 2018',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_сентябрь2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Мониторинг цен за август 2018',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_август2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Мониторинг цен за июль 2018',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_июль2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Мониторинг цен за май 2018',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_май2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Мониторинг цен за апрель 2018',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_апрель2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Мониторинг цен за март 2018',
                        'file'  => '/file/info/Мониторинг_цен/Price_Monitoring_март2018.pdf'
                    ],
                ]
            ],
            [
                'title' => 'Сравнение показателей топлива ОПТИ',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Сравнение 92 клиенту',
                        'file'  => '/file/info/Сравнение_показателей_топлива_ОПТИ/Сравнение_92_клиенту.doc'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Сравнение 95 клиенту',
                        'file'  => '/file/info/Сравнение_показателей_топлива_ОПТИ/Сравнение_95_клиенту.doc'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Сравнение 98 клиенту',
                        'file'  => '/file/info/Сравнение_показателей_топлива_ОПТИ/Сравнение_98_клиенту.doc'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Сравнение ДТз клиенту',
                        'file'  => '/file/info/Сравнение_показателей_топлива_ОПТИ/Сравнение_ДТз_клиенту.doc'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Doc'],
                        'name'  => 'Сравнение ДТл клиенту',
                        'file'  => '/file/info/Сравнение_показателей_топлива_ОПТИ/Сравнение_ДТл_клиенту.doc'
                    ],
                ]
            ]
        ];

        $this->tpl
            ->bind('files', $files)
        ;
	}

    /**
     * рекламно-информационные материалы
     */
    public function action_marketing()
    {
        $this->title[] = 'Рекламно-информационные материалы';

        $files = [
            [
                'title' => 'Материалы',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['File'],
                        'name'  => 'Баннер 240х400',
                        'file'  => '/file/info/Материалы/баннер_240х400.ai'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['File'],
                        'name'  => 'Баннер 468x60',
                        'file'  => '/file/info/Материалы/баннер_468х60.ai'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['File'],
                        'name'  => 'Инфо-стикер',
                        'file'  => '/file/info/Материалы/инфо-стикер_new.ai'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['File'],
                        'name'  => 'Листовка 100x210',
                        'file'  => '/file/info/Материалы/листовка_100x210.ai'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['File'],
                        'name'  => 'Логоблок',
                        'file'  => '/file/info/Материалы/логоблок.ai'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Логоблок',
                        'file'  => '/file/info/Материалы/логоблок.pdf'
                    ],
                ]
            ],
            [
                'title' => 'Создание бренда',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Использование брендов Компании дилерами и агентами',
                        'file'  => '/file/info/Создание_бренда/Использование_брендов_Компании_дилерами_и_агентами.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Корпоративная брошюра ГПН-КП',
                        'file'  => '/file/info/Создание_бренда/Корпоративная_брошюра_ГПН-КП.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Топливная карта Газпром нефть',
                        'file'  => '/file/info/Создание_бренда/Топливная_карта_Газпром_нефть.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Топливная корзина сети АЗС Газпромнефть',
                        'file'  => '/file/info/Создание_бренда/Топливная_корзина_сети_АЗС_Газпромнефть.pdf'
                    ],
                ]
            ]
        ];

        $this->tpl
            ->bind('files', $files)
        ;
    }

    /**
     * паспорта качества
     */
    public function action_passports()
    {
        $this->title[] = 'Паспорта качества';

        $files = [
            [
                'title' => 'Паспорта качества',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '92',
                        'file'  => '/file/info/Паспорта_качества/92.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '95',
                        'file'  => '/file/info/Паспорта_качества/95.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '95G',
                        'file'  => '/file/info/Паспорта_качества/95G.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Декларация ДТС',
                        'file'  => '/file/info/Паспорта_качества/Декларация_ДТС.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'ДТФ',
                        'file'  => '/file/info/Паспорта_качества/ДТФ.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Опти',
                        'file'  => '/file/info/Паспорта_качества/Опти.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Кемерово',
                        'file'  => '/file/info/Паспорта_качества/Кемерово.pdf'
                    ],
                ]
            ],
            [
                'title' => 'Центральный регион',
                'items' => [
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Паспорт 92 от 05.02.2019',
                        'file' => '/file/info/Паспорта_качества/Сибирь/Паспорт_92_от_05.02.2019.pdf'
                    ],
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Паспорт 95 от 07.02.2019',
                        'file' => '/file/info/Паспорта_качества/Сибирь/Паспорт_95_от_07.02.2019.pdf'
                    ],
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Паспорт ДтЗ от 07.02.2019',
                        'file' => '/file/info/Паспорта_качества/Сибирь/Паспорт_ДтЗ_от_07.02.2019.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '№3536 ДТ-Л-К5 от 05.09.2018',
                        'file'  => '/file/info/Паспорта_качества/Центральный_регион/3536_ДТ-Л-К5от05.09.2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '№2520 Аи-92-К5 от 05.09.2018',
                        'file'  => '/file/info/Паспорта_качества/Центральный_регион/2520_Аи-92-К5_от_05.09.2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '№2507 Аи-95-К5 от 03.09.2018',
                        'file'  => '/file/info/Паспорта_качества/Центральный_регион/2507_Аи-95-К5_от_03.09.2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Паспорт качества 2018.07.15 19-01 Р-р №6',
                        'file'  => '/file/info/Паспорта_качества/Центральный_регион/Паспорт_качества_2018.07.15_19-01_Р-р_6.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '2007',
                        'file'  => '/file/info/Паспорта_качества/Центральный_регион/2007.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '2004',
                        'file'  => '/file/info/Паспорта_качества/Центральный_регион/2004.pdf'
                    ],
                ]
            ],
            [
                'title' => 'Сибирь',
                'items' => [
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Паспорт 92 от 04.02.2019',
                        'file' => '/file/info/Паспорта_качества/Сибирь/Паспорт_92_от_04.02.2019.pdf'
                    ],
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Паспорт 95 от 06.02.2019',
                        'file' => '/file/info/Паспорта_качества/Сибирь/Паспорт_95_от_06.02.2019.pdf'
                    ],
                    [
                        'icon' => Common::$infoFilesIcons['Pdf'],
                        'name' => 'Паспорт ДтЗ от 06.02.2019',
                        'file' => '/file/info/Паспорта_качества/Сибирь/Паспорт_ДтЗ_от_06.02.2019.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '№1504 G-Drive 100 от 03.08.2018',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/1504_G-Drive_100_от_03.08.2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => '№2496 G-Drive 100 от 02.09.2018',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/2496_G-Drive_100_от_02.09.2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Сибирь',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/Сибирь.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'ДТзОпти 5 518 от 22.03.2018-вр',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/ДТзОпти_5_518_от_22.03.2018-вр.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Паспорт 92 23.01.2018',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/Паспорт_92_23_01_2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Паспорт 92 Опти',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/Паспорт_92_Опти.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Паспорт 95 23.01.2018',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/Паспорт_95_23_01_2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Паспорт ДТЗ 21.01.2018',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/Паспорт_ДТЗ_21_01_2018.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Паспорт ДТЗ ЕВРО',
                        'file'  => '/file/info/Паспорта_качества/Сибирь/Паспорт_ДТЗ_ЕВРО.pdf'
                    ],
                ]
            ],
            [
                'title' => 'Урал',
                'items' => [
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'АИ-95',
                        'file'  => '/file/info/Паспорта_качества/Урал/АИ-95.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'АИ-92',
                        'file'  => '/file/info/Паспорта_качества/Урал/АИ-92.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'АИ-100',
                        'file'  => '/file/info/Паспорта_качества/Урал/АИ-100.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'ДТ',
                        'file'  => '/file/info/Паспорта_качества/Урал/ДТ.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'АИ-95-К5 ГОСТ 32513-2013',
                        'file'  => '/file/info/Паспорта_качества/Урал/АИ-95-К5_ГОСТ_32513-2013.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Газ углеводородный сжиженный ГОСТ Р 52087-2003',
                        'file'  => '/file/info/Паспорта_качества/Урал/Газ_углеводородный_сжиженный_ГОСТ_Р_52087-2003.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Газ углеводородный сжиженный топливный для коммунально-бытового потребления марки ПТ (пропан технический) по ГОСТ 20448-90 (50295605&nbsp;v1)',
                        'file'  => '/file/info/Паспорта_качества/Урал/Газ_углеводородный_сжиженный_топливный_для_коммунально-бытового_потребления_марки_ПТ_пропан технический_по_ГОСТ_20448-90_50295605_v1.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Дизель Опти ДТ-З-К5',
                        'file'  => '/file/info/Паспорта_качества/Урал/Дизель_Опти_ДТ-З-К5.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'ДТ арктическое ДТ-А-К5 минус 44',
                        'file'  => '/file/info/Паспорта_качества/Урал/ДТ_арктическое_ДТ-А-К5_минус_44.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'ДТ ЕВРО К5 ГОСТ 32511-2013',
                        'file'  => '/file/info/Паспорта_качества/Урал/ДТ_ЕВРО_К5_ГОСТ_32511-2013.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'ДТ ЕВРО К5 ГОСТ Р 52368-2005',
                        'file'  => '/file/info/Паспорта_качества/Урал/ДТ_ЕВРО_К5_ГОСТ_Р_52368-2005.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Премиум Евро-95 К5',
                        'file'  => '/file/info/Паспорта_качества/Урал/Премиум_Евро-95_К5.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Регуляр-92 К5',
                        'file'  => '/file/info/Паспорта_качества/Урал/Регуляр-92_К5.pdf'
                    ],
                    [
                        'icon'  => Common::$infoFilesIcons['Pdf'],
                        'name'  => 'Регуляр-92 ГОСТ 32513-2013',
                        'file'  => '/file/info/Паспорта_качества/Урал/Регуляр-92_ГОСТ_32513-2013.pdf'
                    ],
                ]
            ],
        ];

        $this->tpl
            ->bind('files', $files)
        ;
    }
}
