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

	}

    /**
     * рекламно-информационные материалы
     */
    public function action_marketing()
    {
        $this->title[] = 'Рекламно-информационные материалы';
    }

    /**
     * паспорта качества
     */
    public function action_passports()
    {
        $this->title[] = 'Паспорта качества';
    }
}
