<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception_403 extends Kohana_HTTP_Exception_403
{
    public function get_response()
    {
        $response = Response::factory();

        $view = View::factory('errors/403');

        $response->body($view->render());

        if (Common::isProd()) {
            (new Sentry())->error403('URL: ' . $this->request()->uri());
        }

        return $response;
    }
}
