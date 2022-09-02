<?php
	$host = 'localhost'; // адрес сервера 

	if ($_POST['base'] == 'BigPak') {
		$database = 'bigpak';
	}
	elseif ($_POST['base'] == 'Ring') {
		$database = 'loyal';
	}

	$user = 'user'; // имя пользователя
	$password = 'pass'; // пароль	

	$conn = new mysqli($host, $user, $password, $database);

    if($conn->connect_error) die ($conn->connect_error);
    $conn->set_charset('utf8');

	$query = "SELECT * FROM `CASHGROUP`";

	$result =$conn->query($query);
    if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

    $rows = $result->num_rows;

    $resp;

    for ($i = 0; $i < $rows; $i++) {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_NUM);
        if (!($database == 'bigpak')) {
	        $resp[] = [
	            "id" => $row[0],
	            "name" => $row[1],
	        ];
    	} else {
    		$resp[] = [
	            "id" => "8",
	            "name" => "Орск",
	        ];
    	}

        $str = json_encode($resp);
    }

    echo $str;
?>