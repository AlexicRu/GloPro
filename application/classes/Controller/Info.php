<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Info extends Controller_Common
{
    /**
     * инфо-портал
     */
	public function action_index()
	{
        $this->title[] = 'Информационный портал';
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
