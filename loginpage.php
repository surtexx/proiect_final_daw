<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="loginstyle.css">
	</head>

	<body>
	<nav>
		<a class="nav_item" href="index.php">Acasă</a>
		<?php if(!isset($_SESSION['name'])){ ?>
		<a class="nav_item" href="loginpage.php">Contact</a>	
		<a class="nav_item" href="loginpage.php">Loturi</a>
		<a class="nav_item" href="loginpage.php">Login</a>
		<?php }else { ?>
		<a class="nav_item" href="contact.php">Contact</a>
		<a class="nav_item" href="loturi.php">Loturi</a>
		<a class="nav_item" href="logout.php"><?=$_SESSION['name']?></a>
		<?php if($_SESSION['grad'] == 'admin') { ?>
		<a class="nav_item" href="admpanel.php">Admin Panel</a>
		<?php }} ?>
	</nav>
        <br>
        <main>
                <form action="login.php" method="post">
					<h2>Login to your account</h2>
					<?php if (isset($_GET['errorlogin'])) { ?>
					<h3><?php echo $_GET['errorlogin']; ?></h3>
					<?php } ?>
					<input type="text" name="login_user" placeholder="User"><br><br>
					<input type="password" name="login_password" placeholder="Password"><br><br>
					<button type="submit">Login</button>

                </form>
				
				<form action = "create_account.php" method="post">
					<h2>Create account</h2>
					<?php if (isset($_GET['errorcreate'])) { ?>
					<h3><?php echo $_GET['errorcreate']; ?></h3>
					<?php } ?>
					<input type="text" name="create_user" placeholder="User"><br><br>
					<input type="password" name="create_password" placeholder="Password"><br><br>
					<input type="password" name="copy_password" placeholder="Same password"><br><br>
					<button type="submit">Create</button>
				</form>
        </main>
	</body>
</html>
