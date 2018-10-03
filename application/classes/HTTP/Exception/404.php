<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404
{
    public function get_response()
    {
        $response = Response::factory();

        list($customView, $title) = Common::checkCustomDesign();

        $view = View::factory('errors/404')
            ->bind('title', $title)
            ->bind('customView', $customView)
        ;

        // We're inside an instance of Exception here, all the normal stuff is available.
        $view->message = $this->getMessage();

        $response->body($view->render());

        //(new Sentry())->error404('URL: '.$this->request()->uri());

        return $response;
    }
}
