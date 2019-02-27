<?php defined('SYSPATH') or die('No direct script access.');

class Model_Info extends Model
{
    const INFO_CATEGORY_ID_INFO = 23;
    const INFO_CATEGORY_ID_RIM = 24;
    const INFO_CATEGORY_ID_PASSPORTS = 25;

    const INFO_STATUS_VISIBLE = 1;
    const INFO_STATUS_DELETED = 7;

    const INFO_ACTION_ADD = 1;
    const INFO_ACTION_EDIT = 2;
    const INFO_ACTION_DELETE = 3;

    public static $infoFilesIcons = [
        'pdf' => 'far fa-2x fa-file-pdf text-danger',
        'xls' => 'far fa-2x fa-file-excel text-success',
        'xlsx' => 'far fa-2x fa-file-excel text-success',
        'doc' => 'far fa-2x fa-file-word text-primary',
        'docx' => 'far fa-2x fa-file-word text-primary',
        'ppt' => 'far fa-2x fa-file-powerpoint text-warning',
        'pptx' => 'far fa-2x fa-file-powerpoint text-warning',
        'file' => 'far fa-2x fa-file text-muted',
    ];

    /**
     * получаем список файлов
     *
     * @return array|bool
     */
    public static function getFiles($params = [])
    {
        $db = Oracle::init();

        $sql = (new Builder())->select()
            ->from('v_web_info_portal')
            ->where('status  = ' . self::INFO_STATUS_VISIBLE);

        if (isset($params['id'])) {
            $sql->where('id = ' . (int)$params['id']);
        }

        if (isset($params['category_id'])) {
            $sql->where('category_id = ' . (int)$params['category_id']);
        }

        if (isset($params['is_category'])) {
            $sql->where('is_category = ' . (int)$params['is_category']);
        }

        if (!empty($params['order_by_is_category'])) {
            $sql->orderBy(['is_category', 'sort']);
        } else {
            $sql->orderBy('sort');
        }

        return $db->query($sql);
    }

    /**
     * добавляем элемент инфопортала
     *
     * @param $params
     * @return bool
     */
    public static function editInfoElement($params, $action = self::INFO_ACTION_ADD)
    {
        if (
            ($action == self::INFO_ACTION_ADD && (empty($params['name']) || !isset($params['category_id']))) &&
            ($action != self::INFO_ACTION_ADD && empty($params['id']))
        ) {
            return false;
        }

        $db = Oracle::init();
        $user = User::current();

        $id = !empty($params['id']) ? $params['id'] : 0;

        //если есть id то получаем данные, чтобы можно было передавать в $params неполные данные
        if (!empty($id)) {
            $elements = self::getFiles(['id' => $id]);

            if (empty($elements)) {
                Messages::put('Элемент с данным id отсутствует');
                return false;
            }

            $element = reset($elements);
        }

        if ($action == self::INFO_ACTION_DELETE) {
            $params['category_id'] = $element['CATEGORY_ID'];
            $params['name'] = $element['NAME'];
            $params['is_category'] = $element['IS_CATEGORY'];
            $params['file_path'] = $element['FILE_PATH'];
            $params['sort'] = $element['SORT'];
        } else {
            $params['is_category'] = isset($params['is_category']) ? (int)(bool)$params['is_category'] : $element['IS_CATEGORY'];
            $params['file_path'] = $params['is_category'] ? false : (!empty($params['file']) ? $params['file'] : $element['FILE_PATH']);
        }

        $data = [
            'p_id' => $id ?: -1,
            'p_action' => $action,
            'p_category_id' => isset($params['category_id']) ? $params['category_id'] : $element['CATEGORY_ID'],
            'p_name' => !empty($params['name']) ? $params['name'] : $element['NAME'],
            'p_is_category' => $params['is_category'],
            'p_file_path' => $params['file_path'],
            'p_sort' => !empty($params['sort']) ? $params['sort'] : $element['SORT'],
            'p_manager_id' => $user['MANAGER_ID'],
            'p_error_code' => 'out',
        ];

        $res = $db->procedure('info_portal_edit', $data);

        return $res == Oracle::CODE_SUCCESS ? true : false;
    }

    /**
     * удаляем элемент
     *
     * @param $id
     * @return bool
     */
    public static function deleteInfoElement($id)
    {
        return self::editInfoElement(['id' => $id], self::INFO_ACTION_DELETE);
    }

    /**
     * получаем дерево
     *
     * @params $parentCategory
     */
    public static function getTree($parentCategory = 0)
    {
        $files = self::getFiles(['order_by_is_category' => true]);

        foreach ($files as &$file) {
            if ($file['IS_CATEGORY'] == 0) {
                $extension = 'file';

                $array = explode('.', $file['FILE_PATH']);
                $end = end($array);

                if (isset(self::$infoFilesIcons[$end])) {
                    $extension = $end;
                }

                $file['icon'] = self::$infoFilesIcons[$extension];
            }
        }

        $files = !empty($files) ? self::_buildTree($files, $parentCategory) : [];

        return $files;
    }

    /**
     * получаем дерево секций
     */
    public static function getSectionsTree()
    {
        $sections = self::getFiles(['is_category' => 1, 'order_by_is_category' => true]);

        return !empty($sections) ? self::_buildTree($sections) : [];
    }

    /**
     * билдим дерево
     *
     * @param array $elements
     * @param int $parentId
     * @return array
     */
    private static function _buildTree(array &$elements, $parentId = 0)
    {

        $branch = array();

        foreach ($elements as &$element) {

            if ($element['CATEGORY_ID'] == $parentId) {
                $children = self::_buildTree($elements, $element['ID']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[$element['ID']] = $element;
                unset($element);
            }
        }

        return $branch;
    }
}