<?php
$host = 'localhost'; // адрес сервера 
$database = 'manager';
$user = 'user'; // имя пользователя
$password = 'pass'; // пароль	

$conn = new mysqli($host, $user, $password, $database);

if($conn->connect_error) die ($conn->connect_error);
$conn->set_charset('utf8');

$query = 'UPDATE `SOTCLIEN`
		  SET ID_PROFIL = "7"
		  WHERE ID_CLIENT = "19" and
				LOGIN = "sb"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
		  SET ID_PROFIL = "15"
		  WHERE ID_CLIENT = "85" and
				LOGIN = "sb"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());


$query = 'UPDATE `SOTCLIEN`
				  SET ACTIVE = "7"
				  WHERE ID_CLIENT = "19" and
				    	LOGIN = "econom"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
				  SET ACTIVE = "15"
				  WHERE ID_CLIENT = "85" and
				    	LOGIN = "econom"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
				  SET ID_PROFIL = "7"
				  WHERE ID_CLIENT = "19" and
				    LOGIN = "kistanova.oe"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
				  SET ID_PROFIL = "15"
				  WHERE ID_CLIENT = "85" and
				    LOGIN = "kistanova.oe"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
		  SET ID_PROFIL = "7"
		  WHERE ID_CLIENT = "19" and
				LOGIN = "smirnova.sn"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
		  SET ID_PROFIL = "15"
		  WHERE ID_CLIENT = "85" and
				LOGIN = "smirnova.sn"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
		  SET ID_PROFIL = "7"
		  WHERE ID_CLIENT = "19" and
				LOGIN = "eshmuratova.dk"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

$query = 'UPDATE `SOTCLIEN`
		  SET ID_PROFIL = "15"
		  WHERE ID_CLIENT = "85" and
				LOGIN = "eshmuratova.dk"';

$result =$conn->query($query);
if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

?>
