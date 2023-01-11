<!DOCTYPE html>
<html>
<head>
    <title>Rezultate</title>
    <link rel="stylesheet" href="rezultate.css">
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
            $echipa = $_SESSION['echipa'];
            $url = file_get_contents("https://lpf.ro/cluburi/$echipa/rezultate");
            $dom = new \DOMDocument();
            @$dom->loadHTML($url);
            $divs = $dom->getElementsByTagName('div');
            $results_divs = array();
            foreach($divs as $div)
                if($div->hasAttribute('class') && $div->getAttribute('class') == 'meci-card white-shadow meci-card-rezultate')
                    $results_divs[] = $div;
                else if($div->hasAttribute('class') && $div->getAttribute('class') == 'club-logo-big')
                    $div_logo = $div;
            $logo = 'https://lpf.ro/' . $div_logo->getElementsByTagName('img')->item(0)->getAttribute('src');
            for($i=1;$i<=count($results_divs);$i++)
                foreach($results_divs as $div)
                    foreach($div->getElementsByTagName('div') as $search_div)
                        if ($search_div->getAttribute('class') == 'meci-etapa'){
                            $nr_etapa = substr($search_div->nodeValue,6,2);
                            if(strpos($nr_etapa, "S") !== false && substr($nr_etapa,0,1) == "$i")
                                echo "<div style='border:1px solid black;background-color:#d0d2b0;display:flex;flex-direction:column;align-items:center;'><span>Etapa " . substr($nr_etapa,0,1) . '</span><span>';
                            else if($nr_etapa == "$i")
                                echo "<div style='border:1px solid black;background-color:#d0d2b0;display:flex;flex-direction:column;align-items:center;'><span>Etapa " . $nr_etapa . '</span><span>';
                            else
                                break;
                        }   
                        else if($search_div->getAttribute('class') == 'meci-details-center')
                            foreach($search_div->getElementsByTagName('div') as $small_div)
                                switch($small_div->getAttribute('class')){
                                    case 'echipa1-logo':
                                        echo '<img style="width:50px;height:50px;" src="https://lpf.ro/' . $small_div->getElementsByTagName('img')->item(0)->getAttribute('src') . '">';
                                        break;
                                    case 'echipa1-text':
                                        echo $small_div->nodeValue . ' ';
                                        break;
                                    case 'vs-center':
                                        foreach($div->getElementsByTagName('span') as $span){
                                            if($span->getAttribute('class') == 'scor-center')
                                                echo " - ";
                                            else if($span->getAttribute('class') == 'scor-goluri')
                                                echo $span->nodeValue;
                                        }
                                        break;
                                    case 'echipa2-text':
                                        echo ' ' . $small_div->nodeValue;
                                        break;
                                    case 'echipa2-logo':
                                        echo '<img style="width:50px;height:50px;" src="https://lpf.ro/' . $small_div->getElementsByTagName('img')->item(0)->getAttribute('src') . '"></span></div>';
                                        break;
                                }
            
        ?>
    </main>
</body>
</html>