<?php

class Controller {

	public $model;
	public $view;


	function __construct($model_name) {
		$this->model = new $model_name();
		$this->view = new View();
	}
}