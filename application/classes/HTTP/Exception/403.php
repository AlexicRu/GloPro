<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception_403 extends Kohana_HTTP_Exception_403
{
    public function get_response()
    {
        $response = Response::factory();

        list($customView, $title) = Common::checkCustomDesign();

        $view = View::factory('errors/403')
            ->bind('title', $title)
            ->bind('customView', $customView)
        ;

        $response->body($view->render());

        if ($this->request()->is_ajax()) {
            $response->headers('Content-Type', 'application/json');
            $response->body(json_encode(['success' => false, 'data' => 'Доступ запрещен']));
        } else {
            if (Common::isProd()) {
                (new Sentry())->error403('URL: ' . $this->request()->uri());
            }
        }

        return $response;
    }
}
