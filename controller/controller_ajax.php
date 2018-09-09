<?php
class Controller_ajax {

    public function __construct()
    {
        $img = $_POST['photo'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);
        //saving
        $user = $_SESSION['user']['usr_name'];
        $userDir = "css/photo/$user/";
        if (file_exists($userDir)) {
            $fileName =  $userDir  . time() . "_$user" .'.png';
        } else {
            $userDir = mkdir("css/photo/$user/", 0700);
            $fileName = $userDir . time() . "_$user" .'.png';
        }
        file_put_contents($fileName, $fileData);
    }
}