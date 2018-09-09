<?php
use PHPMailer\PHPMailer\PHPMailer;
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';

class Model_main extends Model
{

    private $conn;
    private $mail;

    public function sendMail()
    {
        $this->mail = new PHPMailer();
        $this->mail->setFrom('camagru@mail.com');
        $this->mail->addAddress($_SESSION['user']['email'], $_SESSION['user']['usr_name']);
        $this->mail->Subject = "You have new comment";
        $this->mail->isHTML(true);
        $this->mail->Body = "You have new comment to your photo";
        $this->mail->send();
    }

    public function getUserTable()
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $prepare = $this->conn->prepare('SELECT `usr_name`, `user_id`, `email` FROM user;');
            $prepare->execute();
            $prepare->setFetchMode(PDO::FETCH_ASSOC);
            return $prepare->fetchAll();
        } catch (PDOException $e) {
            echo "Get USER DATA FAILD" . $e->getMessage();
        }
    }

    public function getPhotoTable()
    {
        $this->conn = parent::db_connection();
        $this->conn->setAttribute(3, 2);
        try {
            $sql = sprintf("SELECT * FROM photo ORDER BY date_crt DESC;");
            $result = $this->conn->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result = $result->fetchAll();
            return $result;
        } catch (PDOException $e) {
            echo "Get Photo Table Data Failed";
        }
    }

    public function getCommentsTable()
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $prepare = $this->conn->prepare("SELECT user_id, user_name, photo_id, comment_text FROM COMMENTS ORDER BY date_crt DESC;");
            $prepare->execute();
            return $prepare->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Get comments Table Data Failed";
        }
    }

    public function getCountLikesTable($photo_id)
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $sql = $this->conn->prepare("SELECT COUNT(*) FROM likes WHERE photo_id = '$photo_id';");
            $sql->execute();
            $result = $sql->fetchAll();
            return $result[0][0];
        } catch (PDOexception $e) {
            echo "Get likes Table Data failed";
        }
    }

    public function pushComments()
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $prepare = $this->conn->prepare("INSERT INTO comments (photo_id, user_id, comment_text, user_name) VALUES (?, ?, ?, ?)");
            $prepare->execute(array($_POST['photo_id'], $_SESSION['user']['user_id'], htmlentities($_POST['text'], ENT_SUBSTITUTE | ENT_QUOTES | ENT_HTML5), $_SESSION['user']['usr_name']));

            if ($_SESSION['user']['send_alert'] === 1) {
                $this->sendMail();
            }
        } catch (PDOException $e) {
            echo "Add comment is Failed";
        }

    }

    public function addLikes()
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $photo_id = $_POST['photo_id'];
            $user_id = $_SESSION['user']['user_id'];
            $prepare = $this->conn->prepare("INSERT INTO likes (user_id, photo_id) VALUES (?, ?)");
            $prepare->execute(array($_SESSION['user']['user_id'], $_POST['photo_id']));

        } catch (PDOException $e) {
            "Add likes is Failed";
        }
    }

    public function getLikesTable()
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $sql = $this->conn->prepare("SELECT * FROM likes");
            $sql->execute();
            $result = $sql->fetchAll(2);
            return $result;
        } catch (PDOexception $e) {
            echo "Get likes Table Data failed";
        }
    }

    public function removeLikeFromTable()
    {
        try {
            $this->conn = parent::db_connection();
            $this->conn->setAttribute(3, 2);
            $photo_id = $_POST['photo_id'];
            $user_id = $_SESSION['user']['user_id'];
            $sql = $this->conn->prepare("DELETE FROM likes WHERE user_id = '$user_id' AND photo_id = '$photo_id'");
            $sql->execute();
        } catch (PDOexception $e) {
            echo "Remove likes from Table Data failed";
        }
    }

    public function deletePhoto($photo_id, $image_path)
    {
        $image_path = substr($image_path, 2);
        if (file_exists(ROOT . $image_path)) {
            unlink(ROOT . $image_path);
            $this->conn = parent::db_connection();
            $sql = $this->conn->prepare("DELETE FROM photo WHERE photo_id = '$photo_id'");
            $sql->execute();
            $sql = $this->conn->prepare("DELETE * FROM comets WHERE photo_id = '$photo_id'");
            $sql->execute();
            $sql = $this->conn->prepare("DELETE * FROM likes WHERE photo_id = '$photo_id'");
            $sql->execute();
        }
    }

}