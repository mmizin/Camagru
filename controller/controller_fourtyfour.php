<?php
/**
 * Created by PhpStorm.
 * User: nmizin
 * Date: 8/27/18
 * Time: 10:08 AM
 */

class Controller_fourtyfour extends Controller
{
    public function __construct($contant, $templateView, $routes = null)
    {
        parent::__construct($contant);

        $this->view->render(null, $templateView, null);
    }
}