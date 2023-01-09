<!DOCTYPE html>
<html>
<head>
	<title>Contact</title>
	<link rel="stylesheet" href="contactstyle.css">
</head>
<body>
<?php
	session_start();
    if(!isset($_SESSION['name'])){
        header('Location:index.php');
    }
?>
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
        <form method="POST" action="procesare_contact.php">
        <label for="email">Email:</label><br>
        <input type="email" name="email"><br>
        <label for="message">Mesaj:</label><br>
        <textarea style="resize:none;" name="message" rows="10" cols="80"></textarea><br>
        <label for="captcha">Introduceti codul din imagine:</label><br>
        <?php
	    require 'captcha.php';
            $PHPCAP->prime();
            $PHPCAP->draw();
        ?>
        <?php if (isset($_GET['errorcaptcha'])) { ?>
            <h3><?php echo $_GET['errorcaptcha']; ?></h3>
        <?php } ?>
        <input type="text" name="captcha" required><br>
        <input type="submit" value="Trimite">
        </form>
        <?php if (isset($_GET['message'])) { ?>
            <h3><?php echo $_GET['message']; ?></h3>
        <?php } ?>
    </main>
</body>
</html>
