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
				<input type="text" name="create_user" placeholder="User" required><br><br>
				<input type="password" name="create_password" placeholder="Password" required><br><br>
				<input type="password" name="copy_password" placeholder="Same password" required><br><br>
				<label for="captcha">Introduceti codul din imagine:</label><br>
				<?php
					require "captcha.php";
					$PHPCAP->prime();
					$PHPCAP->draw();
				?>
				<?php if (isset($_GET['errorcaptcha'])) { ?>
					<h3><?php echo $_GET['errorcaptcha']; ?></h3>
				<?php } ?>
				<br>
				<input type="text" name="captcha" required><br><br>
				<label for="echipe">Alege-ți o echipă preferată:</label><br><br>
				<select name="echipe" id="echipe">
					<option value="-">-</option>
					<?php
						for($i=0;$i<$n_places;$i++){
							echo "<option value=$link_echipe[$i]>$echipe[$i]</option>";
						}
					?>
				</select>
				<br><br>
				<button type="submit">Create</button>
			</form>
        </main>
	</body>
</html>
