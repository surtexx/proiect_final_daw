<!DOCTYPE html>
<html>
<head>
    <title>Loturi</title>
    <link rel="stylesheet" href="loturistyle.css">
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
        <form action="procesare_lot.php" method="post">
            <label for="echipe">Alegeți o echipă pentru a-i vedea lotul:</label><br><br>
            <select name="echipe" id="echipe" onchange="this.form.submit()">
                <option value="-">-</option>
                <?php
                    for($i=0;$i<$n_places;$i++){
                        echo "<option value=$link_echipe[$i]>$echipe[$i]</option>";
                    }
                ?>
            </select>
        </form>
    </main>
</body>
</html>