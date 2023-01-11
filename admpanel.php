<!DOCTYPE html>
<html>
<head>
	<title>Admin Panel</title>
	<link rel="stylesheet" href="panelstyle.css">
</head>
<body>
<?php
	session_start();
    if($_SESSION['grad'] != 'admin'){
        header('Location:index.php');
    }
?>
	<nav>
    <a class="nav_item" href="index.php">Acasă</a>
		<?php if(!isset($_SESSION['name'])){ ?>
		<a class="nav_item" href="loginpage.php">Contact</a>
		<a class="nav_item" href="loginpage.php">Loturi</a>
        <a class="nav_item" href="loginpage.php">Rezultate echipa favorita</a>
		<a class="nav_item" href="loginpage.php">Login</a>
		<?php }else { ?>
		<a class="nav_item" href="contact.php">Contact</a>
		<a class="nav_item" href="loturi.php">Loturi</a>
        <a class="nav_item" href="rezultate.php">Rezultate echipa favorita</a>
		<a class="nav_item" href="profile.php"><?=$_SESSION['name']?></a>
		<?php if($_SESSION['grad'] == 'admin') { ?>
		<a class="nav_item" href="admpanel.php">Admin Panel</a>
		<?php }} ?>
	</nav>
    <br>
    <main>
        
        <form action="deleteuser.php" method="post">
            <label for="deleteuser">Introduceți userul pentru a îl șterge: </label>
            <?php if (isset($_GET['deletemessage'])) { ?>
				<h3><?php echo $_GET['deletemessage']; ?></h3>
            <?php } ?>
            <input type="text" name="usertodelete" id="usertodelete" placeholder="Username">
            <input type="submit" value="Șterge"></input>
        </form>
        <form action="createadminuser.php" method="post">
            <span>Introduceți un username și o parolă pentru a crea un nou admin: </span><br>
            <?php if (isset($_GET['createadminmessage'])) { ?>
				<h3><?php echo $_GET['createadminmessage']; ?></h3>
            <?php } ?>
            <input type="text" name="adminusername" id="adminusername" placeholder="Username"><br>
            <input type="password" name="adminpassword" id="adminpassword" placeholder="Password"><br>
            <input type="password" name="admincopypassword" id="admincopypassword" placeholder="Same password"><br>
            <input type="submit" value="Creează admin"></input>
        </form>

        <form action="modifygrade.php" method="post">
            <span>Introduceți un user existent și noul grad pe care să îl aibă (admin/user): </span><br>
            <?php if (isset($_GET['modifymessage'])) { ?>
				<h3><?php echo $_GET['modifymessage']; ?></h3>
            <?php } ?>
            <input type="text" name="nametomodify" id="nametomodify" placeholder="Username"><br>
            <input type="text" name="gradetomodify" id="gradetomodify" placeholder="Grad"><br>
            <input type="submit" value="Modifică user"></input>
        </form>
    </main>
</body>
</html>