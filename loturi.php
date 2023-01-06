<!DOCTYPE html>
<html>
<head>
    <title>Loturi</title>
    <link rel="stylesheet" href="loturistyle.css">
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
        <form action="procesare_lot.php" method="post">
            <label for="echipe">Alegeți o echipă pentru a-i vedea lotul:</label><br><br>
            <select name="echipe" id="echipe" onchange="this.form.submit()">
                <option value="-">-</option>
                <option value="fc-petrolul/32">FC Petrolul Ploiești</option>
                <option value="fc-arges/27">FC Argeș</option>
                <option value="universitatea-craiova/9">Universitatea Craiova</option>
                <option value="fcsb/3">FCSB</option>
                <option value="fc-cfr-1907-cluj/5">CFR Cluj</option>
                <option value="fc-farul-constanta/12">FC Farul Constanța</option>
                <option value="afc-hermannstadt/19">AFC Hermannstadt</option>
                <option value="fc-botosani/8">FC Botoșani</option>
                <option value="afc-chindia-targoviste/20">AFC Chindia Târgoviște</option>
                <option value="cs-mioveni/28">CS Mioveni</option>
                <option value="fcu-1948-craiova/29">FCU 1948 Craiova</option>
                <option value="fc-rapid-1923/30">FC Rapid București</option>
                <option value="fc-universitatea-cluj/33">Universitatea Cluj</option>
                <option value="sepsi-osk/16">Sepsi OSK</option>
                <option value="uta-arad/22">UTA Arad</option>
                <option value="fc-voluntari/6">FC Voluntari</option>
            </select>
        </form>
    </main>
</body>
</html>