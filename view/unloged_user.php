<?php
//echo '<pre>';
//print_r($photoTableData);
//echo '</pre>';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/css/main_style.css">
    <title>Main</title>
</head>
<body>
<div class="container">

    <header class="">
        <nav class="nav">
            <div class="nav-logo">
                <a href="#">CAMAGRU</a>
            </div>
            <a class="button" href="#">
                <div class="nav-user">

                </div>
            </a>
            <a class="button" href="#">
                <div class="nav-admin">

                </div>
            </a>
            <a href="<?php echo "/logout"; ?>">
                <div class="nav-logout">
                    <img src="../css/photo/registration_icon.jpg" style="width:50px; height: 50px;" alt="">
                    <br>Registration
                </div>
            </a>
        </nav>
    </header>

    <aside class="left"></aside>

    <!--        /******************************** MAIN START MAIN START MAIN START MAIN START MAIN START ********************************************/-->

    <main class="main">
        <?php foreach ($photoTableData as $item => $value) { ?>

            <div class="main-wrap" id="<?php echo $value['photo_id'];?>">
                <div class="user_name"><?php echo $value['user_name']; ?></div>
                <div class="photo_user">
                    <img src="<?php echo $value['local_path']; ?>" alt="">
                </div>
                <div class="likes_comments">
                </div>
                </div>

        <?php } ?>

    </main>

    <!--        /************************** MAIN END MAIN END MAIN END MAIN END MAIN END MAIN END MAIN END MAIN END ************************/-->


    <aside class="right"></aside>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $count_of_pages; $i++) {?>
        <a data-page="<?php echo $i;?>" href="/unloged_user"><?php echo $i;?></a>
    <?php }?>
</div>
<footer class="">
    <div class="footer">
        <p>
            made by nmizin
        </p>


    </div>
</footer>

<script type="text/javascript" src="../js/main.js"></script>

</body>
</html>