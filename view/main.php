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
					<a href="/main/<?php echo $_SESSION['user']['usr_name']; ?>">CAMAGRU</a>
				</div>
				<a class="button" href="#">
				<div class="nav-user">
                        <img  src="<?php echo $_SESSION['user']['avatar']?>" onclick="location.href = '/gallery/' + '<?php echo $_SESSION['user']['usr_name'];?>'">
                    <br> <?php echo $_SESSION['user']['usr_name']; ?>
                </div>
				</a>
				<a class="button" href="<?php echo "/" . "admin/" . $_SESSION['user']['usr_name']; ?>">
				<div class="nav-admin">
                    <img src="<?php  echo "../css/photo/admin_icon.png"; ?>" alt="">
                   <br> Admin
                </div>
				</a>
                <a href="<?php echo "/logout"; ?>">
                    <div class="nav-logout">
                        <img src="../css/photo/log_out_icon.png" alt="">
                        <br>Logout
                    </div>
                </a>
			</nav>
		</header>

		<aside class="left"></aside>

<!--        /******************************** MAIN START MAIN START MAIN START MAIN START MAIN START ********************************************/-->

        <main class="main">
            <?php foreach ($photoTableData as $item => $value) { ?>

            <div class="main-wrap" id="<?php echo $value['photo_id'];?>" data-display="on">
                <div class="user_name"><?php echo $value['user_name']; ?></div>
                <div class="photo_user">
                    <img src="<?php echo $value['local_path']; ?>" alt="">
                </div>
                <div class="likes_comments">
                    <img class="heart_icon" src="../css/photo/heart_icon.png" alt="" data-id="<?php echo $value['photo_id'];?>" onclick="heart_icon(this)">
                    <img class="comment_icon" src="../css/photo/comment_icon.png" onclick="say(this)" alt="">
                  


                </div>
                <div class="count_of_likes" data-id="<?php echo $value['photo_id'];?>"><?php echo $value['likes'];?></div>
                <div class="add_comments">
                    <form action="#" method="post">
                        <input style="display: none;" name="photo_id" value="<?php echo $value['photo_id']; ?>" >
                        <textarea aria-label="Add a comment…" placeholder="Add a comment…"  class="t_area" name="t_area" autocomplete="off" autocorrect="off"></textarea>
                        <button class="btn_send_comment" data-id="<?php echo $value['photo_id'];?>" type="button" onclick="comment(event)">Send</button>
                    </form>
                    <?php if (!empty($value['comments'])) {
                        foreach ($value['comments'] as $item2=>$value2) { ?>
                            <div class="user_coments">
                                <span class="user_comment_name"> <?php  echo $value2['user_name']; ?></span>
                                <span class="user_text_comment"><?php echo $value2['comment_text'];?></span>
                            </div>
                        <?php }}?>

                </div>

            </div>
            <?php } ?>

		</main>

<!--        /************************** MAIN END MAIN END MAIN END MAIN END MAIN END MAIN END MAIN END MAIN END ************************/-->


		<aside class="right"></aside>
	</div>
    <div class="pagination">
        <?php for ($i = 1; $i <= $count_of_pages; $i++) {?>
            <a data-page="<?php echo $i;?>" href="/main/<?php echo $_SESSION['user']['usr_name'];?>"><?php echo $i;?></a>
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