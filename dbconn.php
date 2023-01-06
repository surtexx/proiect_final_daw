<?php

$hostname= "eu-cdbr-west-03.cleardb.net";

$username= "b4b8f7a8a51606";

$password = "eaec6074";

$db_name = "heroku_2c28b94d12e4acc";

$conn = mysqli_connect($hostname, $username, $password, $db_name);

if (!$conn) {

    echo "Connection to database failed!";

}
