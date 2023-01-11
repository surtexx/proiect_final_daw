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
        <?php
			$url = file_get_contents('https://lpf.ro/liga-1');
			$dom = new \DOMDocument();
			@$dom->loadHTML($url);
			$tables = $dom->getELementsByTagName('table');
			$clasament_table = $dom->createElement('table');
			foreach($tables as $t_table){
				if ($t_table->hasAttribute('class') && $t_table->getAttribute('class') == 'clasament_general white-shadow') {
					$clasament_table = $t_table;
					break;
				}
			}
			$tds = $clasament_table->getElementsByTagName('td');
			$trs = $clasament_table->getElementsByTagName('tr');
			$n_places = 0;
			$echipe = array();
			$link_echipe = array();
			foreach ($tds as $td) {
				if ($td->hasAttribute('class') && $td->getAttribute('class') == 'echipa'){
					$n_places += 1;
					$echipa = $td->getElementsByTagName('a')->item(0)->nodeValue;
					if(strpos($echipa,'*') !== false)
						$echipe[] = substr($echipa,0, strlen($echipa)-1);
					else
						$echipe[] = $echipa;
					$splitted_href = explode('/', $td->getElementsByTagName('a')->item(0)->getAttribute('href'));
					$link_echipe[] = $splitted_href[1] . '/' . $splitted_href[2];
				}
			}
        ?>
        <form action="deleteuser.php" method="post">
            <label for="deleteuser">Introduceți userul pentru a îl șterge: </label>
            <?php if (isset($_GET['deletemessage'])) { ?>
				<h3><?php echo $_GET['deletemessage']; ?></h3>
            <?php } ?>
            <input type="text" name="usertodelete" id="usertodelete" placeholder="Username">
            <input type="submit" value="Șterge"></input>
        </form>
        <form action="createadminuser.php" method="post">
            <span>Introduceți un username, o parola si o echipa preferata pentru a crea un nou admin: </span><br>
            <?php if (isset($_GET['createadminmessage'])) { ?>
				<h3><?php echo $_GET['createadminmessage']; ?></h3>
            <?php } ?>
            <input type="text" name="adminusername" id="adminusername" placeholder="Username"><br>
            <input type="password" name="adminpassword" id="adminpassword" placeholder="Password"><br>
            <input type="password" name="admincopypassword" id="admincopypassword" placeholder="Same password"><br>
				<select name="echipe" id="echipe">
					<option value="-">-</option>
					<?php
						for($i=0;$i<$n_places;$i++){
							echo "<option value=$link_echipe[$i]>$echipe[$i]</option>";
						}
					?>
				</select>
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
