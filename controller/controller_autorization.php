<?php


class  Controller_autorization extends Controller
{

    public function __construct($contant, $templateView, $routes)
    {
        $addUser = null;
        $info = null;

        if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            header("Location: /");
        }

        parent::__construct($contant);

        $token = substr(str_shuffle('qwertyuiop[]QWERTYUIOP[]123456789'), 0, 10);
        $userTable = $this->model->getUsersTable();

        if (isset($_GET['token'])) {
            $this->model->confirmRegistration();
        }
        if (isset($_POST['registration'])) {
            $info = array('registration' => $this->model->checkRegistration($userTable));
            if (empty($info['registration'])) {
                $addUser = $this->model->addNewUser($token);
            }
        }
        if (isset($_POST['log_in'])) {
            $info = array('log_in' => $this->model->checkLogIn($userTable));
        }
        if (isset($_POST['new_password'])) {

            $info['recovery'] = $this->model->checkForRecoveryPassword();
        }
        if (isset($_GET['recovery_password'])) {
            $this->model->confirmRecoveredPassword();
        }

        $data = array('info' => $info, 'addUser' => $addUser);
        if (!empty($_POST['log_in']) && $data['info']['log_in'] != 'Something go Wrong') {
            header("Location: /main/" . $data['info']['log_in']);
        }
        $this->view->render(null, $templateView, $data);

    }
}


