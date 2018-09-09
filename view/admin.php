<?php
//echo '<pre>';
//print_r($change_msg);
//echo '</pre>';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/css/admin_style.css">
    <script type="text/javascript" src="../js/admin.js"></script>

    <title>Camagru</title>
</head>
<body>
    <div class="wrap">

            <div class="logo">
                <a href="/main/<?php echo $_SESSION['user']['usr_name'];?>">CAMAGRU</a>
            </div>
            <div class="user">
                <a href="/gallery/<?php echo $_SESSION['user']['usr_name'];?>">
                    <img src="<?php echo $_SESSION['user']['avatar']?>">
                    <br><?php echo $_SESSION['user']['usr_name']; ?>
                </a>
            </div>
            <div class="admin">
                <a href="<?php echo "/" . "admin/" . $_SESSION['user']['usr_name']; ?>">
                   <img class="myImage" src="<?php  echo "../css/photo/admin_icon.png"; ?>" alt="">
                   <br>Admin
               </a>

            </div>
            <div class="logout">
                <a href="<?php echo "/logout"; ?>">
                    <img src="../css/photo/log_out_icon.png" alt="">
                    <br>logout
                </a>
            </div>

        <div class="right-bar">
            <a id="modal-href" href="#">
            <img src="<?php echo $_SESSION['user']['avatar'] ?>" alt="">
            <br>Change profile photo
            </a>
            <div class="myModal">
                <div class="modal-content">
                    <span class="close_modal">&times;</span>
                        <div class="upload_photo_profile">Upload photo
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" id="fileToUpload">
                                <button type="submit"  name="avatar_upload">Upload img</button>
                            </form>
                        </div>
                        <div class="make_photo_from_webacm">Make photo from webcam
                            <div class="upload_webcam">
                                <form action="" method="post">
                                    <button type="button" class="button_snap_avatar" name="avatar_webcam">
                                        Snap photo
                                    </button>
                                    <button type="button" class="save_avatar_from_webcam">
                                        Save
                                    </button>
                                </form>
                                <video id="video_avatar" width="640" height="480" autoplay></video>
                                <canvas id="canvas_avatar" width="640" height="480"></canvas>
                            </div>

                        </div>

                </div>
            </div>
        </div>

        <div class="change_name change" data-blockid="new_name">Change Username</div>
        <div class="change_email change" data-blockid="new_email">Change Email</div>
        <div class="change_password change" data-blockid="new_password">Change Password</div>
        <div class="upload_photo change" data-blockid="new_upload_photo">Upload photo</div>
        <div id="snap">Snap Photo</div>
        <div id="save_photo">Save Photo</div>
        <div class="receive_notification">
            <label for="notification_mail">Notification mail</label>
            <input type="checkbox" id="notification_mail" name="notification_mail" <?php if($_SESSION['user']['send_alert'] === 1) {echo 'checked';} else {echo '';}?> onclick="notification(event)">
        </div>

        <!-- _________MAIN_____BAR__________ACTIVE _____START____-->
        <div class="main-bar active"><?php echo $_SESSION['user']['usr_name']; ?>

            <div class="new_name active">
                <form action="/admin/<?php echo $_SESSION['user']['usr_name']; ?>" method="post">
                    <input type="text" name="new_name" placeholder="new name" required>
                    <br>
                    <button type="submit" value="ok">Submit</button>
                </form>
            </div>

            <div class="new_email">
                <form action="" method="post">
                    <input type="text" name="new_email" placeholder="new email" required>
                    <br>
                    <button type="submit" value="ok">Submit</button>
                </form>
            </div>


            <div class="new_password">
                <form action="" method="post">
                    <input type="password" name="old_password" placeholder="old password" required>
                    <input type="password" name="new_password" placeholder="new password" required>
                    <br>
                    <button type="submit" value="ok">Submit</button>
                </form>
            </div>
            <div class="new_upload_photo ">
<!--                <div class="upload_photo">Upload photo-->
<!--                    <form action="" method="post" enctype="multipart/form-data">-->
                        <input type="file" name="fileToUpload" id="imgLoader">
<!--                        <input id="imgUpload" type="submit" value="Upload Image" name="imageLoader">-->
<!--                    </form>-->
<!--                </div>-->
            </div>
            <?php if (!empty($change_msg)) { ?>
                <?php   foreach ($change_msg as $item ) { ?>
                <div class="data active" style="color: <?php if ($change_msg[0][0] == 'S' || $change_msg[0][0] == 'I') echo 'red'; else echo "green";?>"><?php echo $item;?></div>
            <?php }}?>
            <?php if (!empty($file_error)) { ?>
                <div class="data active" style="color: <?php if ($file_error[0] == 'Wrong current password') echo 'red'; else echo "palegreen";?>"><?php echo $file_error[0]; ?></div>
            <?php }?>

        </div>

        <div class="canvas_element_video">
            <img src="../css/photo/podlogka/podlogka-1.png" alt=""  class="photo1">
            <img src="../css/photo/podlogka/podlogka-2.png" alt=""  class="photo2">
            <img src="../css/photo/podlogka/podlogka-3.png" alt=""  class="photo3">
        </div>

        <div class="canvas">

            <div class="grid_video">

                    <img class="podlogka_video" src="#" alt="">
                    <canvas id="canvass_podlogka_video"  data-loaded="off" ></canvas>
<!--                <div>-->
                    <video id="video" playsinline muted autoplay></video>
<!--                </div>-->

            </div>

            <div class="gird_canvas">
                <canvas id="canvass"  data-loaded="off" width="640" height="480"></canvas>
            </div>


        </div>

        <!-- _________MAIN_____BAR__________ACTIVE _________END____________-->

        <div class="footer">Footer</div>


    </div>
    <script type="text/javascript" src="../js/admin.js"></script>


</body>
</html>