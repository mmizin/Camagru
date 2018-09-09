<?php
/**
 * Created by PhpStorm.
 * User: nmizin
 * Date: 8/27/18
 * Time: 11:25 AM
 */

class Controller_unloged_user extends Controller
{
    public function __construct($contant, $templateView, $routes = null)
    {
        parent::__construct($contant);

        if (!isset($_SESSION['current_page'])) {
            $_SESSION['current_page'] = 1;
        }
        if (isset($_POST['page'])) {
            $_SESSION['current_page'] = $_POST['page'];
        }

        include ROOT . "/model/model_main.php";
        $model_main = new Model_main();
        $elements_per_page = 5;
        $photoTableData = $model_main->getPhotoTable();

        $count_of_pages = ceil(count($photoTableData) / $elements_per_page);
        $photoTableData = array_slice($photoTableData, ($_SESSION['current_page'] - 1) * 5, 5);
        $result = [
            'photoTableData'=>$photoTableData,
            'count_of_pages'=>$count_of_pages
        ];

        $this->view->render(null, $templateView, $result);

    }
}