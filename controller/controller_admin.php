<?php
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';


Class Controller_admin extends Controller
{

    public function __construct($model_name, $templateView, $routes)
    {

        $result['change_msg'] = [];
        $q = '';

        parent::__construct($model_name);
        if (isset($_POST) && !empty($_POST['new_name'])) {
            $new_name = strip_tags(trim($_POST['new_name']));
            array_push($result['change_msg'], $this->model->changeData('usr_name', htmlentities($new_name, ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5)));
        }
        else if (isset($_POST) && !empty($_POST['new_email'])) {

            array_push($result['change_msg'], $res = $this->model->changeData('email', $_POST['new_email']));
        }
        else if (isset($_POST) && !empty($_POST['new_password']) && !empty($_POST['old_password'])) {
            $old_password = htmlentities(strip_tags(trim($_POST['old_password'])), ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5);
            $new_password = htmlentities(strip_tags(trim($_POST['new_password'])), ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5);
            $result['change_msg'] = $this->model->changeData('password', $new_password, $old_password);
        }
        else if (isset($_POST['avatar_upload']) && !empty($_FILES)) {
           $result = $this->model->addAvatarUpload();
        }
        else if (isset($_POST['avatar_webcam'])) {
          $q = $this->model->addAvatarWebcam();
          echo $q;
          exit ;
        }
        else if (!empty($_POST['for_tbl_photo'])) {
           $this->model->addPhotoToPhotoTable();
           exit ;
        }
        else if (!empty($_POST['imgOne']) || !empty($_POST['two'])) {
            $this->model->lipsPhoto();
        } else if (isset($_POST['notification_email'])) {
            $_POST['notification_email'] === 'true' ?  $_SESSION['user']['send_alert'] = 1 : $_SESSION['user']['send_alert'] = 0;
           $this->model->notificationEmail();
        }


        $this->view->render(null, $templateView, !empty($result) ? $result : null);
    }
}