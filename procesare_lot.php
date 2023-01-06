<!DOCTYPE html>
<html>
<head>
    <title>Loturi</title>
    <link rel="stylesheet" href="procesare_lotstyle.css">
</head>
<body>
    <?php
        session_start();
    ?>
    <nav>
        <a class="nav_item" href="index.php">Acasă</a>
		<a class="nav_item" href="contact.php">Contact</a>
		<?php if(!isset($_SESSION['name'])){ ?>
		<a class="nav_item" href="loginpage.php">Loturi</a>
		<a class="nav_item" href="login.php">Login</a>
		<?php }else { ?>
		<a class="nav_item" href="loturi.php">Loturi</a>
		<a class="nav_item" href="logout.php"><?=$_SESSION['name']?></a>
		<?php if($_SESSION['grad'] == 'admin') { ?>
		<a class="nav_item" href="admpanel.php">Admin Panel</a>
		<?php }} ?>
    </nav>
    <br>
    <main>
        <?php
            $doc = new \DOMDocument();
            @$doc->loadHTMLFile("loturi.php");
            $echipaAleasa = $_POST['echipe'];
            $url = file_get_contents('https://lpf.ro/cluburi/' . $echipaAleasa);
            $loturi_doc = new \DOMDocument();
            @$loturi_doc->loadHTML($url);
            $divs = $loturi_doc->getElementsByTagName('div');
            $players_div = $loturi_doc->createElement('div');
            foreach($divs as $div){
                if($div->hasAttribute('class') && $div->getAttribute('class') == "row lista-jucatori-club"){
                    $players_div = $div;
                    break;
                }
            }
            $players = $players_div->getElementsByTagName('a');
            $names= array();
            $numbers= array();
            $positions= array();
            foreach($players as $player){
                foreach($player->getElementsByTagName('div') as $info){
                    if($info->getAttribute('class') == 'player-name')
                        $names[]= $info->nodeValue;
                    elseif ($info->getAttribute('class') == 'player-role')
                        $positions[] = $info->nodeValue;
                    elseif ($info->getAttribute('class') == 'player-number')
                        $numbers[] = $info->nodeValue;
            }
        }
        $_SESSION['names'] = $names;
        $_SESSION['numbers'] = $numbers;
        $_SESSION['positions'] = $positions;
        echo '<div>Portari:<br>';
        for($i=0;$i<count($names);$i++)
            if($positions[$i] == "Portar")
                echo $numbers[$i] . ' ' . $names[$i] . '<br>';
        echo '</div><div>Fundași:<br>';
        for($i=0;$i<count($names);$i++)
            if($positions[$i] == "Fundaș")
                echo $numbers[$i] . ' ' . $names[$i] . '<br>';
        echo '</div><div>Mijlocași:<br>';
        for($i=0;$i<count($names);$i++)
            if($positions[$i] == "Mijlocaș")
                echo $numbers[$i] . ' ' . $names[$i] . '<br>';
        echo '</div><div>Atacanți:<br>';
        for($i=0;$i<count($names);$i++)
            if($positions[$i] == "Atacant")
                echo $numbers[$i] . ' ' . $names[$i] . '<br>';
        echo '</div><div>Nespecificat:<br>';
        for($i=0;$i<count($names);$i++)
            if($positions[$i] == "-")
                echo $numbers[$i] . ' ' . $names[$i] . '<br>';
        ?>
        <br><br>
        <form method="post" style="position:absolute;bottom:15vh;left:45vw;" action="download_pdf.php">
            <input type="submit" name="download_pdf" value="Click pentru a downloada lotul!">
        </form>
    </main>
</body>
</html>
