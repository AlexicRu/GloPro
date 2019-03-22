<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Info extends Controller_Common
{

    public function before()
    {
        parent::before();

        $this->title[] = 'Информационный портал';
    }

    private function _prepare($parentCategoryId)
    {
        $this->_initDropZone();

        $tree = Model_Info::getSectionsTree();

        $popupInfoAddElement = Form::popupLarge('Добавление/редактирование  элемента', 'info/add_element', [
            'tree' => $tree,
            'parentCategoryId' => $parentCategoryId
        ]);

        return $popupInfoAddElement;
    }

    /**
     * инфо-портал
     */
	public function action_index()
	{
        $parentCategoryId = Model_Info::INFO_CATEGORY_ID_INFO;

        $popupInfoAddElement = $this->_prepare($parentCategoryId);

        $files = Model_Info::getTree($parentCategoryId);

        $this->tpl
            ->bind('popupInfoAddElement', $popupInfoAddElement)
            ->bind('files', $files)
            ->bind('parentCategoryId', $parentCategoryId)
        ;
	}

    /**
     * рекламно-информационные материалы
     */
    public function action_marketing()
    {
        $this->title[] = 'Рекламно-информационные материалы';

        $parentCategoryId = Model_Info::INFO_CATEGORY_ID_RIM;

        $popupInfoAddElement = $this->_prepare($parentCategoryId);

        $files = Model_Info::getTree($parentCategoryId);

        $this->tpl
            ->bind('popupInfoAddElement', $popupInfoAddElement)
            ->bind('files', $files)
            ->bind('parentCategoryId', $parentCategoryId)
        ;
    }

    /**
     * паспорта качества
     */
    public function action_passports()
    {
        $this->title[] = 'Паспорта качества';

        $parentCategoryId = Model_Info::INFO_CATEGORY_ID_PASSPORTS;

        $popupInfoAddElement = $this->_prepare($parentCategoryId);

        $files = Model_Info::getTree($parentCategoryId);

        $this->tpl
            ->bind('popupInfoAddElement', $popupInfoAddElement)
            ->bind('files', $files)
            ->bind('parentCategoryId', $parentCategoryId)
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
