<?php
//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>';
//if (array_key_exists('registration', $error)) {
//	echo '<br>' . "KEY EXIST";
//}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/css/autorization_style.css">
</head>
<body>
<sectio>

	<div class="container">

		<div class="logo">
			<h1>Camagru</h1>
		</div>

		<div class="form autorization">
			<div class="autorization-photo">
				<img src="" alt="">
			</div>
			<div class="dws-form">
				<input type="radio" id="tab-1"  class="input" name="tabs" checked>
				<label class="tab" for="tab-1">Log in</label>

				<input type="radio" class="input" id="tab-2" name="tabs" >
				<label class="tab" for="tab-2">Sign up</label>

				<form action="autorization" id="form-1" method="post" class="tab-form">
					<div class="box-input">
						<input class="input" type="text" name="email"required />
						<label for="">email</label>
					</div>

					<div class="box-input">
						<input class="input" type="password" name="pswd" required />
						<label for="">password</label>
					</div>

					<button class="button" type="submit" name="log_in" value="on">Login</button>

				</form>

				<form id="form-2" method="post" class="tab-form">
					<div class="box-input">
						<input class="input" type="text" name="email" required />
						<label for="">email</label>
					</div>
					<div class="box-input">
						<input class="input" type="password" name="pswd" required/>
						<label for="">password</label>
					</div>
					<div class="box-input">
						<input class="input" type="text" name="usr_name" required/>
						<label for="">name</label>
					</div>
					<button class="button" type="submit" name="registration" value="on">Sign up</button>
				</form>
				<div class="error">
					<?php if (!empty($info['log_in'])) { ?>
						<p><?php echo $info['log_in'] ?></p>
					<?php }?>
				</div>
                <div class="forgot_href">
                    <span>Forgot password?</span>
                    <div class="forgot_password">
                        <form action="autorization" method="post">
                            <input class="input" type="password" name="new_password" placeholder="Enter new password">
                            <input class="input" type="email" name="email_for_recovery" placeholder="Enter email">
                            <button class="button" type="submit">Send</button>
                        </form>
                    </div>
                </div>
				<div class="error">
					<?php if (!empty($info['registration'])) {
						foreach ($info['registration'] as $item) { ?>
							<p><?php echo $item ?></p>
						<?php } ?>
					<?php } else if (!empty($addUser)) { ?>
						<p><?php echo "Confirm your registration via email please" ?></p>
					<?php } if (isset($info['recovery'])) {?>
                    <p><?php echo $info['recovery'];?></p>
                    <?php } ?>

				</div>

			</div>



		</div>
	</div>

</sectio>

<footer>
	<div class="container">

	</div>
</footer>

</body>
</html>
