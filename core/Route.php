<?php
class Route {


	public function start() {

		$routes = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
//
//		echo '<pre>';
//        print_r($routes);
//        echo '</pre>';
//        echo '<pre>';
//        print_r($_SERVER);
//        echo '</pre>';

		if (empty ($routes[0])){
            $controller_name = 'main';
            $model_name = 'main';
		} else if (count($routes) > 2) {
		    $controller_name  = 'fourtyfour';
            $model_name = 'fourtyfour';
        } else if (!isset($_SESSION['user']) && ($routes[0] == 'gallery' || $routes[0] == 'admin')) {
            $controller_name  = 'fourtyfour';
            $model_name = 'fourtyfour';
        } else {
		    $controller_name = $routes[0];
            $model_name = $routes[0];
        }


		$model_class = 'Model_' . $model_name;
//		echo '<br>' . '::: $model_name ::: ' . $model_class;

		$controller_class = 'Controller_' . $model_name;
//		echo '<br>' . '::: $controller_name ::: ' . $controller_class;

		$model_file = strtolower($model_class) . '.php';
//		echo '<br>' . '::: $model_file ::: ' . $model_file;

		$model_path = ROOT . '/model/' . $model_file;
//		echo '<br>' . '::: $model_path ::: ' . $model_path;

		$controller_file = strtolower($controller_class) . ".php";
//		echo '<br>' . '::: $controller_file ::: ' . $controller_file;

		$controller_path = ROOT . '/controller/' . $controller_file;
//		echo '<br>' . '::: controller_path ::: ' . $controller_path;


		if (file_exists($controller_path) && file_exists($model_path)) {
			include "$controller_path";
			include "$model_path";
		} else {
            $controller_class = 'Controller_' . 'fourtyfour';
            $model_class = 'Model_' . 'fourtyfour';
            $controller_name = 'fourtyfour';
            include ROOT . '/model/' . strtolower($model_class) . '.php';
            include ROOT . '/controller/' . strtolower($controller_class) . '.php';
        }

		$controller = new $controller_class($model_class, $controller_name, $routes);

	}
}
