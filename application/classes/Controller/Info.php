<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Info extends Controller_Common
{

    public function before()
    {
        parent::before();

        $this->title[] = 'Информационный портал';
    }

    private function _prepare()
    {
        $this->_initDropZone();

        $tree = Model_Info::getSectionsTree();

        $popupInfoAddElement = Form::popupLarge('Добавление/редактирование  элемента', 'info/add_element', [
            'tree' => $tree
        ]);

        return $popupInfoAddElement;
    }

    /**
     * инфо-портал
     */
	public function action_index()
	{
        $popupInfoAddElement = $this->_prepare();

        $files = Model_Info::getTree(Model_Info::INFO_CATEGORY_ID_INFO);

        $this->tpl
            ->bind('popupInfoAddElement', $popupInfoAddElement)
            ->bind('files', $files)
        ;
	}

    /**
     * рекламно-информационные материалы
     */
    public function action_marketing()
    {
        $this->title[] = 'Рекламно-информационные материалы';

        $popupInfoAddElement = $this->_prepare();

        $files = Model_Info::getTree(Model_Info::INFO_CATEGORY_ID_RIM);

        $this->tpl
            ->bind('popupInfoAddElement', $popupInfoAddElement)
            ->bind('files', $files)
        ;
    }

    /**
     * паспорта качества
     */
    public function action_passports()
    {
        $this->title[] = 'Паспорта качества';

        $popupInfoAddElement = $this->_prepare();

        $files = Model_Info::getTree(Model_Info::INFO_CATEGORY_ID_PASSPORTS);

        $this->tpl
            ->bind('popupInfoAddElement', $popupInfoAddElement)
            ->bind('files', $files)
        ;
    }

    /**
     * добавляем элемент в инфо-портал
     */
    public function action_editElement()
    {
        $params = $this->request->post('params');

        $result = Model_Info::editInfoElement($params, !empty($params['id']) ? Model_Info::INFO_ACTION_EDIT : Model_Info::INFO_ACTION_ADD);

        if (empty($result)) {
            $this->jsonResult(false);
        }
        $this->jsonResult(true);
    }

    /**
     * удаляем элемент из инфо-портала
     */
    public function action_deleteElement()
    {
        $id = $this->request->post('id');

        $result = Model_Info::deleteInfoElement($id);

        if (empty($result)) {
            $this->jsonResult(false);
        }
        $this->jsonResult(true);
    }
}
