<?php

use PHPMailer\PHPMailer\PHPMailer;


class Model_autorization extends Model
{

    private $conn;
    private $mail;

    public function sendMail($token) {
        $user_mail = $_POST['email'];
        $this->mail = new PHPMailer();
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        $this->mail->setFrom('camagru@mail.com');
        $this->mail->addAddress($user_mail, $_POST['usr_name']);
        $this->mail->Subject = "Please verify email";
        $this->mail->isHTML(true);
        $this->mail->Body = "
        Please click on the link below to confirm your registration: <br><br>
        <a href='http://$HTTP_HOST/autorization/?email=$user_mail&token=$token'>Click Here</a>";
        $this->mail->send();
    }

    public function sendMailForRecoveyPassword() {

        $user_mail = filter_var($_POST['email_for_recovery'], FILTER_SANITIZE_EMAIL);
        $user_mail = filter_var($_POST['email_for_recovery'], FILTER_VALIDATE_EMAIL);
        $HTTP_HOST = $_SERVER['HTTP_HOST'];
        $newpassword = htmlentities($_POST['new_password'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5);
        $this->mail = new PHPMailer();

        $this->mail->setFrom('camagru@mail.com');
        $this->mail->addAddress($user_mail);

        $this->mail->Subject = "Recovery password";
        $this->mail->isHTML(true);
        $this->mail->Body = "
        Please click on the link below to confirm new password: <br><br>
        <a href='http://$HTTP_HOST/autorization/?email=$user_mail&recovery_password=$newpassword'>Click Here</a>";
        $this->mail->send();

    }

    public function addNewUser($token)
    {
        $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        try {
            $this->conn = parent::db_connection();
            $sql = sprintf("INSERT INTO user (email, password, usr_name, token) VALUES ('%s', '%s', '%s', '%s')",
                $user_email, hash('whirlpool', htmlentities($_POST['pswd'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5)),
                htmlentities($_POST['usr_name'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5), $token);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->query($sql);
            $result = 'Confirm your registration via email please';
            $this->sendMail($token);
            return $result;
        } catch (PDOException $e) {
            echo "INSERT ERROR: " . $e->getMessage();
            exit(-1);
        }
    }

    public function getUsersTable()
    {

        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM user";
            $result = $this->conn->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo "GET USER TABLE ERROR: " . $e->getMessage();
        }
    }

    public function checkRegistration($userTable)
    {
        $error = array();
        $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
            array_push($error, 'Invalid email format');
            return $error;
        }
        if (!empty($validate = $this->validatePassword())) {
            return $validate;
        }

        foreach ($userTable as $item) {
            foreach ($item as $value => $var) {
                if ($var ==  $user_email) {
                    array_push($error, 'such email is existing');
                }

                if ($var == hash('whirlpool', htmlentities($_POST['pswd'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5))) {
                    array_push($error, 'such password is existing');
                }
                if ($var == htmlentities($_POST['usr_name'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5)) {
                    array_push($error, 'such name is existing');
                }
            }

        }
        return $error;
    }


    public function checkLogIn($userTable)
    {
        $result = 'Something go Wrong';
        $user_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
           return $result;
        }

        foreach ($userTable as $item) {
            if ($item['email'] == $user_email
                && $item['password'] == hash('whirlpool', htmlentities($_POST['pswd'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5))
                && $item['autorization'] == 1)
            {
                $_SESSION = array('user' => array(
                    'user_id'=> $item['user_id'],
                    'usr_name' => $item['usr_name'],
                    'email' => $_POST['email'],
                    'password' => hash('whirlpool', htmlentities($_POST['pswd'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5)),
                    'avatar' => empty($item['avatar']) ? '../css/photo/empty_avatar.png' : $item['avatar'],
                    'send_alert' => (int)$item['send_alert']));
                return $result = $item['usr_name'];
            }
        }
        return $result;
    }

    public function confirmRegistration() {
        $token = $_GET['token'];
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE user SET autorization=1 WHERE token LIKE '$token'";
            $this->conn->query($sql);
        }catch (PDOException $e) {
            echo "CONFIRM IS FAILED: " . $e->getMessage();
        }
    }

    public function checkForRecoveryPassword() {

        $user_email = filter_var($_POST['email_for_recovery'], FILTER_SANITIZE_EMAIL);

        $newpassword = htmlentities($_POST['new_password'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5);
        if (count($this->validatePassword($newpassword)) > 0) {
            return "Wrong password";
        }
//        echo '<pre>';
//        print_r($newpassword);
//        echo '</pre>';
        try {
        $this->conn = parent::db_connection();
        $sql = "SELECT * FROM user WHERE `email` = '$user_email'";
        $result = $this->conn->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            return "Wrong email";
        } else {
            $this->sendMailForRecoveyPassword();
            return "Confirm new password via email please";
        }
        }catch (PDOException $e) {
            echo "Change password is FAILED" . $e->getMessage();
        }
    }

    public function confirmRecoveredPassword() {
        $new_password = hash('whirlpool', $_GET['recovery_password']);
        $email = $_GET['email'];
        try {
            $this->conn = parent::db_connection();
            $sql = "UPDATE user SET `password`='$new_password' WHERE `email`='$email'";
            $this->conn->query($sql);
        }catch (PDOException $e) {
            echo "Change password is FAILED" . $e->getMessage();
        }
    }

    public function validatePassword($pwd = null){
        if ($pwd == null) {
            $pwd =  htmlentities($_POST['pswd'], ENT_SUBSTITUTE|ENT_QUOTES|ENT_HTML5);
        }
        $error = [];
        if(strlen($pwd) < 5) {
            array_push($error,"Password too short!");
        }

        if( strlen($pwd) > 20) {
            array_push($error, "Password too long!");
        }

        if( !preg_match("#[0-9]+#", $pwd) ) {
            array_push($error, "Password must include at least one number!");
        }

        if( !preg_match("#[a-z]+#", $pwd) ) {
            array_push($error, "Password must include at least one letter!");
        }

        if( !preg_match("#[A-Z]+#", $pwd) ) {
            array_push($error, "Password must include at least one CAPS!");
        }

        return $error;
    }
}
