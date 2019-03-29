<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Support extends Controller_Common {

	public function before()
	{
		parent::before();

		$this->title[] = 'Поддержка';
	}

	public function action_index()
	{
        $feedbackForm = View::factory('forms/support/feedback');

        $this->_initDropZone();

        $files = [
            [
                'title' => 'Инструкции',
                'items' => [
                    [
                        'icon' => Model_Info::$infoFilesIcons['doc'],
                        'name'  => 'Инструкция по работе с ЛК системы',
                        'file'  => '/file/Инструкция_по_работе_с_ЛК_системы_Администратор.docx'
                    ],
                ]
            ],
            [
                'title' => 'Заявки',
                'items' => [
                    [
                        'icon' => Model_Info::$infoFilesIcons['doc'],
                        'name'  => 'Заявка подключение к API',
                        'file'  => '/file/Заявка_подключение_к_API.docx'
                    ],
                    [
                        'icon' => Model_Info::$infoFilesIcons['doc'],
                        'name'  => 'Заявка подключение к источнику данных',
                        'file'  => '/file/Заявка_подключение_к_источнику_данных.docx'
                    ],
                    [
                        'icon' => Model_Info::$infoFilesIcons['doc'],
                        'name'  => 'Заявка подключение к источнику данных ГПН',
                        'file'  => '/file/Заявка_подключение_к_источнику_данных_ГПН.docx'
                    ],
                ]
            ],
        ];

        foreach ($files as $key1 => $block) {
            foreach ($block['items'] as $key2 => $file) {
                if (!Access::file($file['file'])) {
                    unset($files[$key1]['items'][$key2]);
                }
            }
            if (empty($files[$key1]['items'])) {
                unset($files[$key1]);
            }
        }

        $this->tpl
            ->bind('feedbackForm', $feedbackForm)
            ->bind('files', $files)
        ;
	}

    /**
     * отправка сообщения обратной связи
     */
	public function action_feedback()
    {
        $subject = $this->request->post('subject');
        $email = $this->request->post('email');
        $text = $this->request->post('text');
        $files = $this->request->post('files');

        $user = User::current();

        $subject = 'ЛК [Agent '. $user['AGENT_ID'] .' - '. $user['LOGIN'] .'] ' . $subject;
        $description = 'Email: ' . $email . "\n\n" . $text;

        $issueId = (new Redmine())->createIssue($subject, $description, (array)$files);

        if (!empty($issueId) && is_numeric($issueId)) {
            $subject = 'Заявка №'. $issueId .' ' . $subject;
            $message = 'Ваша заявка успешно принята в работу!<br><br>' . $text;

            Email::send($email, Email::FROM, $subject, $message);
        }

        $this->jsonResult(is_numeric($issueId), $issueId);
    }
}
