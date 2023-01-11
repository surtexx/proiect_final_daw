<!DOCTYPE html>
<html>
<head>
	<title>Acasă</title>
	<link rel="stylesheet" href="indexstyle.css">
</head>
<body>
<?php
	session_start();
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
		<?php if (isset($_GET['success'])) { ?>
			<h3><?php echo $_GET['success']; ?></h3>
		<?php }
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
			foreach ($tds as $td) {
				if ($td->hasAttribute('class') && $td->getAttribute('class') == 'poz'){
					$n_places += 1;
				}
			}
			echo '<table>';
			echo '<th> <td>Echipa</td>';
			foreach($trs[0]->getElementsByTagName('td') as $td)
				if($td->nodeValue != ''){
					if($td->nodeValue == 'MJ')
						echo '<td> Meciuri jucate</td>';
					else if($td->nodeValue == 'Î')
						echo '<td style="color:red"> Înfrângeri </td>';
					else if($td->nodeValue == 'E')
						echo '<td style="color:yellow"> Egaluri </td>';
					else if($td->nodeValue == 'V')
						echo '<td style="color:green"> Victorii </td>';
					else if($td->nodeValue == 'GM')
						echo '<td> Goluri Marcate </td>';
					else if($td->nodeValue == 'GP')
						echo '<td> Goluri primite </td>';
					else if($td->nodeValue == 'G')
						echo '<td> Golaveraj </td>';
					else if($td->nodeValue == 'P')
						echo '<td> Puncte </td>';
					else
						echo '<td>' . $td->nodeValue . '</td>';
				}
			echo '</th>';
			for($i=1; $i<count($trs);$i++){
				echo '<tr>';
				foreach($trs[$i]->getElementsByTagName('td') as $td)
					if($td->nodeValue != ''){
						if(strpos($td->nodeValue, '?') !== false){
							echo '<td>';
							for($j=1;$j<strlen($td->nodeValue);$j++){
								if($td->nodeValue[$j] == 'E')
									echo '<span style="color:yellow"> E </span>';
								else if ($td->nodeValue[$j] == 'V')
									echo '<span style="color:green"> V </span>';
								else
									echo '<span style="color:red"> Î </span>';
							}
							echo '</td>';
						}
						else{
							if(strpos($td->nodeValue,'*') !== false)
								echo '<td>' . substr($td->nodeValue,0, strlen($td->nodeValue)-1) . '</td>';
							else
								echo '<td>' . $td->nodeValue . '</td>';
						}
					}
				echo '</tr>';
			}
			echo '</table>';
			$divs = $dom->getElementsByTagName('div');
			$my_div = $dom->createELement('div');
			foreach($divs as $div)
				if($div->hasAttribute('class') && $div->getAttribute('class') == 'section-title' && strpos($div->nodeValue, 'Program')){
					$my_div = $div;
					break;
				}
			$my_div = preg_split('/\s+/', $my_div->nodeValue);
			echo '<div style="position:relative;top:40px;">Program ' . $my_div[0] . ' ' . $my_div[1] . "<br><br>";
			$fixtures_table = $dom->createElement('table');
			foreach($tables as $table){
				if ($table->hasAttribute('class') && $table->getAttribute('class') == 'clasament_general white-shadow etape_meciuri') {
    				$fixtures_table = $t_table;
					break;
  				}
			}
			$fixtures_a = $fixtures_table->getElementsByTagName('a');
				$count = 0;
				foreach($fixtures_a as $a){
					if(strpos($a->getAttribute('href'), 'cluburi') !== false){
						if($count == 0){
							if(strpos($a->nodeValue, '*') !== false)
								echo substr($a->nodeValue, 0, strpos($a->nodeValue, '*')) . ' - ';
    						else
        						echo $a->nodeValue . ' - ';
    						$count = 1;
						}
						else{
							if(strpos($a->nodeValue, '*') !== false)
								echo substr($a->nodeValue, 0, strpos($a->nodeValue, '*')) . '<br>';
							else
								echo $a->nodeValue . '<br>';                                         
							$count = 0;
							}
					}
				}
		?>
        </main>
</body>
</html>