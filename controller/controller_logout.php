<?php
Class Controller_logout extends Controller {

    public function __construct($model_name)
    {
        parent::__construct($model_name);
        header("Location: autorization");
    }
}