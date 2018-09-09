<?php
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

class Controller_main extends Controller
{

    public function __construct($contant, $templateView, $routes = null)
    {
        $result['photoTableData'] = [];
        if (empty($_SESSION['user'])) {
            header("Location: /unloged_user");
        }
        $userData = array();

        parent::__construct($contant);

//        if (isset($_POST['t_area']) && !empty($_POST['t_area'])) {
//            $this->model->pushComments();
//            header("Location: /main");
//        }
        if (isset($_POST['text']) && !empty($_POST['text']) && !empty(trim($_POST['text']))) {
            $this->model->pushComments();
            $q = array(htmlentities(trim($_POST['text']), ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5), $_SESSION['user']['usr_name']);
            $q = json_encode($q);
            echo $q;
            exit;
        }


        /*
         * @@@@@@@@@@@@@@@@@@@@@@@ FILL PHOTO TABLE WITH COMMENTS AND LIKES @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
         * */

        if (isset($_POST['delete_photo'])) {
            $this->model->deletePhoto($_POST['delete_photo'], $_POST['photo_path']);
            exit ;
        }

        /*
        * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        * */







        if (!isset($_SESSION['current_page'])) {
            $_SESSION['current_page'] = 1;
        }
        if (isset($_POST['page'])) {
            $_SESSION['current_page'] = $_POST['page'];
        }

        $elements_per_page = 5;

        $photoTableData = $this->model->getPhotoTable();
        $userTable = $this->model->getUserTable();
        $commentsTable = $this->model->getCommentsTable();
        $likesTable = $this->model->getLikesTable();

        /*
         * @@@@@@@@@@@@@@@@@@@@@@@ FILL PHOTO TABLE WITH COMMENTS AND LIKES @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
         * */
        foreach ($photoTableData as $photo_item => $photo_value) {
            // create COMMENTS array
            $photoTableData[$photo_item]['comments'] = array();
            // create LIKES index and set '0' as default
            if (!isset($photoTableData[$photo_item]['likes'])) {
                $photoTableData[$photo_item]['likes'] = '0';
            }

            foreach ($commentsTable as $comment_item) {
                if ($photo_value['photo_id'] === $comment_item['photo_id']) {
                    // fill COMMENTS array with user_name and comment_text
                    array_push($photoTableData[$photo_item]['comments'],
                        array('user_name' => $comment_item['user_name'], 'comment_text' => $comment_item['comment_text']));
                }
            }
            // fill index LIKES with function wich return count of likes
            foreach ($likesTable as $item) {
                if ($photo_value['photo_id'] === $item['photo_id']) {
                    $photoTableData[$photo_item]['likes'] = $this->model->getCountLikesTable($photo_value['photo_id']);
                }
            }

        }
        /*
         * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
         * */


        /*
         * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ ADD LIKES @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
         * */

        if (!empty($_POST['photo_id']) && $_POST['add_like'] == 1) {
            foreach ($likesTable as $item => $val) {
                if ($val['user_id'] == $_SESSION['user']['user_id'] && $val['photo_id'] == $_POST['photo_id']) {
                    $this->model->removeLikeFromTable();
                    echo json_encode(array($this->model->getCountLikesTable($_POST['photo_id']), 0));
                    exit;
                }
            }

            $this->model->addLikes();
            echo json_encode(array($this->model->getCountLikesTable($_POST['photo_id']), 1));
            exit;
        }

        /*
         * @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
         * */

        $count_of_pages = ceil(count($photoTableData) / $elements_per_page);
        $photoTableData = array_slice($photoTableData, ($_SESSION['current_page'] - 1) * 5, 5);
        $result = [
            'photoTableData' => $photoTableData,
            'count_of_pages' => $count_of_pages
        ];

        $this->view->render(null, $templateView, $result);
    }
}
