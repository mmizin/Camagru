<?php

//echo '<pre>';
//print_r($_SESSION['user']);
//echo '</pre>';
Class Model_admin extends Model {

    private $conn;
    const IMG_SIZE = 2000000;

    public function changeData($column_name, $new_data, $old_pass = null) {
        include 'model_autorization.php';
        $model_admin = new Model_autorization();
        include 'model_main.php';
        $model_main = new Model_main();
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($old_pass != null ) {
                if (!empty($valid = $model_admin->validatePassword($new_data))) {
                    return $valid;
                }
               if (hash('whirlpool', $old_pass) == $_SESSION['user']['password']) {
                   $new_data = hash('whirlpool', $new_data);
                   $sql = sprintf("UPDATE user SET %s='$new_data' WHERE usr_name='%s';", $column_name, $_SESSION['user']['usr_name']);
                   $result = $this->conn->query($sql);
                   $_SESSION['user']["$column_name"] = $new_data;
                   return("$column_name successfully changed");
               }
               return ('Wrong current password');
            } else {
                $valid = $model_main->getUserTable();
                if ($column_name == 'usr_name') {
                    foreach ($valid as $item) {
                        if ( $item['usr_name'] == $new_data) {
                            return "Such user name is exist ! Please choose another name";
                        }
                    }
                } else if($column_name == 'email') {

                    $new_data = filter_var($new_data, FILTER_SANITIZE_EMAIL);

                    if (!filter_var($new_data, FILTER_VALIDATE_EMAIL)){
                       return 'Invalid email format';
                    }
                    foreach ($valid as $item) {
                        if ($item['email'] == $new_data) {
                            return "Such email is exist ! Please choose another email";
                        }
                    }
                }
                $sql = sprintf("UPDATE user SET %s='$new_data' WHERE usr_name='%s';", $column_name, $_SESSION['user']['usr_name']);
                $result = $this->conn->query($sql);
                $_SESSION['user']["$column_name"] = $new_data;
                return ("$column_name successfully changed");

            }

        } catch (PDOException $e) {
            echo "Get USER DATA FAILD" . $e->getMessage();
        }
    }

    public function addAvatarUpload() {
        $this->conn = parent::db_connection();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {

            $result['change_msg'] = [];
            $result['file_error'] = [];
            $check = '';
            $targetDir = ROOT . "/css/photo/";
            $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
//            echo '<br>' . $targetFile;

            //Check that file was chosen
            if (!empty($_FILES["fileToUpload"]["tmp_name"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            }

            if ($check !== false) {
//                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                array_push($result['file_error'], "File is not an image.");
//                echo "File is not an image.";
                $result = array('file_error' => "File is not an image.");
                $uploadOk = 0;
            }

            if ($_FILES["fileToUpload"]["size"] > self::IMG_SIZE) {
                array_push($result['file_error'], "Sorry, your file is too large.");
//                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                array_push($result['file_error'], "Sorry, your file was not uploaded.");
//                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                    $_SESSION['user']['avatar'] = "../css/photo/" . basename($_FILES["fileToUpload"]["name"]);
                    array_push($result['change_msg'], "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.");
                    $sql = sprintf("UPDATE user SET avatar = '%s' WHERE usr_name = '%s'",
                        "../css/photo/" . basename($_FILES["fileToUpload"]["name"]), $_SESSION['user']['usr_name']);
                    $this->conn->query($sql);
                } else {
                    array_push($result['file_error'], "Sorry, there was an error uploading your file.");
//                    echo "Sorry, there was an error uploading your file.";
                }

            }


            return $result;

        }catch (PDOException $e) {
            echo "Add avatar_user FAILED";
        }
    }

    public function addAvatarWebcam() {

        $this->conn = parent::db_connection();
        $this->conn->setAttribute(3, 2);
        try {
            $img = $_POST['avatar_webcam'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $user = $_SESSION['user']['user_id'];
            $userDir = "css/photo/id_$user/";
            if (file_exists($userDir)) {
                $fileName = $userDir . time() . "_ID_$user" . '.png';
            } else {
                $userDir = mkdir("css/photo/id_$user/", 0700);
                $fileName = $userDir . time() . "_ID_$user" . ".png";
            }
            file_put_contents($fileName, $fileData);
            $sql = sprintf("UPDATE user SET avatar = '../%s' WHERE user_id = '%s'",
                $fileName, $_SESSION['user']['user_id']);
            $this->conn->query($sql);
            $res = '../' . $fileName;
            $_SESSION['user']['avatar'] = $res;
            return $res;
        } catch (PDOException    $e) {
            echo "Add avatar_user FAILED";
        }
    }
    public function addPhotoToPhotoTable() {
        $this->conn = parent::db_connection();
        $this->conn->setAttribute(3, 2);
        try {
            $img = $_POST['for_tbl_photo'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $user = $_SESSION['user']['user_id'];
            $userDir = "css/photo/id_$user/";
            if (file_exists($userDir)) {
                $fileName = $userDir . time() . "_ID_$user" . '.png';
            } else {
                $userDir = mkdir("css/photo/id_$user/", 0700);
                $fileName = $userDir . time() . "_ID_$user" . ".png";
            }
            file_put_contents($fileName, $fileData);
            $sql = sprintf("INSERT INTO photo (user_id, local_path, user_name) VALUES ('%s', '../%s', '%s')",
                $_SESSION['user']['user_id'], $fileName, $_SESSION['user']['usr_name']);
            $this->conn->query($sql);
            return $res = '../' . $fileName;
        } catch (PDOException $e) {
            echo "Add photo to table Failed";
        }
    }

    function resizePng($im, $dst_width, $dst_height) {
        $width = imagesx($im);
        $height = imagesy($im);

        $newImg = imagecreatetruecolor($dst_width, $dst_height);

        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
        imagecopyresampled($newImg, $im, 0, 0, 0, 0, $dst_width, $dst_height, $width, $height);
        return $newImg;
    }

    public function lipsPhoto() {
        $imgOne = $_POST['imgOne'];
        $imgOne = str_replace('data:image/png;base64,', '', $imgOne);
        $imgOne = str_replace(' ', '+', $imgOne);
        $imgOne_decode = base64_decode($imgOne);
        $imgOne_decode = imagecreatefromstring($imgOne_decode);
        if (!empty($_POST['imgTwo'])) {
            $imgTwo = str_replace("../", '', $_POST['imgTwo']);    // $_SERVER CHANGE PATH
            $imgTwo = file_get_contents($imgTwo);
            $imgTwo = $this->resizePng(imagecreatefromstring($imgTwo), 640, 480);
            imagecopy($imgOne_decode, $imgTwo, 0, 0, 0, 0, 640, 480);
        }
        ob_start ();
        imagepng($imgOne_decode);
        $image_data = ob_get_contents ();
        ob_end_clean ();
        $image_data_base64 = base64_encode($image_data);
        echo ($image_data_base64);
        exit ;
    }

    public function notificationEmail() {
        $answer = $_POST['notification_email'] === 'true' ? 1 : 0;
        $user = $_SESSION['user']['user_id'];
        $this->conn = parent::db_connection();
        $this->conn->setAttribute(3, 2);
        try {
            $sql = "UPDATE user SET send_alert = '$answer' WHERE user_id = '$user'";
            $this->conn->query($sql);

        } catch (PDOException $e) {
            echo "Add photo to table Failed";
        }
    }

}
