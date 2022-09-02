<?php
	class CLASSUM {
		public $DATE;
		public $CARD;
		public $CHECK;
		public $SUMMA;

		function __construct($DATE, $CARD, $CHECK, $SUMMA) {
			$this->DATE = $DATE;
			$this->CARD = $CARD;
			$this->CHECK = $CHECK;
			$this->SUMMA = $SUMMA;
		}
	}

	class Report {
		public $DATE;
		public $CARD;
		public $CHECK;
		public $SUMMA;
		public $CHECKSUM;

		function __construct($DATE, $CARD, $CHECK, $SUMMA, $CHECKSUM) {
			$this->DATE = $DATE;
			$this->CARD = $CARD;
			$this->CHECK = $CHECK;
			$this->SUMMA = $SUMMA;
			$this->CHECKSUM = $CHECKSUM;
		}
	}

	function binarySearch($list, $item) {
		$low = 0;
		$high = count($list) - 1;
		while ($low <= $high) {
			$mid = round(($low + $high)/2);
			$guess = $list[$mid]->CARD;
			if ($item == $guess) { return $mid;}
			if ($guess > $item) { $high = $mid - 1; }
			else { $low = $mid + 1; }
		}
		return 0;
	}


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

    if ($_POST['base'] == 'BigPak') {
		$query = "SELECT * FROM `CASHGROUP` WHERE NAME = 'Орск'";
	} else {
		if ($_POST['city'] == "Все") {
			$query = "SELECT * FROM `CASHGROUP`";
		} else {
			$query = "SELECT * FROM `CASHGROUP` WHERE NAME = '".$_POST['city']."'";
		}
	}

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
    }

    $query = "SELECT * FROM `CASH` WHERE ID_CASHGROUP = '".$resp[0]["id"]."'";

    $result =$conn->query($query);
    if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

    $rows = $result->num_rows;

    $resp;

    for ($i = 0; $i < $rows; $i++) {
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_NUM);
    	$resp[] = [
            "id" => $row[0],
            "name" => $row[2],
        ];
    }

    if ($_POST['city'] == "Все") {
		$str = "";
	} else {
		$str = " and (";
	    for ($i = 0; $i <= (count($resp) - 1); $i++) {
	    	if ($i == 0) {
	    		$str = $str."ID_CASH = '".$resp[$i]["id"]."' or ";
	    	} 
	    	if (($i > 0) and ($i < count($resp) - 1)) {
	    		$str = $str."ID_CASH = '".$resp[$i]["id"]."' or ";
	    	} 
	    	if ($i == count($resp) - 1) {
	    		$str = $str."ID_CASH = '".$resp[$i]["id"]."'";
	    	}
	    }
	    $str = $str.") ";	
	}

    $query = "SELECT DATE_FORMAT(FROM_UNIXTIME(`CHANGETIME`), '%d.%m.%Y') as Dat, 
					CARD.CODE, COUNT(CHEK), SUM(BONUS) 
				FROM (
					SELECT ID_CASH, CHANGETIME, ID_CARD, ID_CHEQUE as CHEK, 
						SUM(BALANCE) as BONUS 
					FROM `OPER` 
					WHERE CHANGETIME >= UNIX_TIMESTAMP('".$_POST['dat1']."') 
						and CHANGETIME <= UNIX_TIMESTAMP('".$_POST['dat2']."')".$str."
					GROUP BY `OPER`.ID_CHEQUE) as CHEK 
				LEFT OUTER JOIN CARD on (ID_CARD = CARD.ID) 
				WHERE CHANGETIME >= UNIX_TIMESTAMP('".$_POST['dat1']."') 
					and CHANGETIME <= UNIX_TIMESTAMP('".$_POST['dat2']."')".$str."
				GROUP BY ID_CARD ORDER BY CARD.CODE";

	echo $query;

	// $result =$conn->query($query);
 //    if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

 //    $rows = $result->num_rows;

 //    for ($i = 0; $i < $rows; $i++) {
 //        $result->data_seek($i);
 //        $row = $result->fetch_array(MYSQLI_NUM);
 //        $bonus[] = new CLASSUM($row[0], $row[1], $row[2], $row[3]);
 //    }


	// $query2 = "SELECT DATE_FORMAT(FROM_UNIXTIME(`CHANGETIME`), '%d.%m.%Y') as Dat,
	// 					CARD.CODE, `OPER`.ID_CHEQUE, SUM(`PAYCHEQUE`.PAY_SUM) as SUMCHEK
	// 				FROM `OPER` 
	// 				LEFT OUTER JOIN `PAYCHEQUE` on (`OPER`.ID_CHEQUE = `PAYCHEQUE`.ID_CHEQUE)
	// 				LEFT OUTER JOIN CARD on (OPER.ID_CARD = CARD.ID)
	// 				WHERE CHANGETIME >= UNIX_TIMESTAMP('".$_POST['dat1']."')
	// 					and CHANGETIME <= UNIX_TIMESTAMP('".$_POST['dat2']."')".$str."
	// 				GROUP BY `OPER`.ID_CHEQUE
	// 				ORDER BY CARD.CODE";

	// $result =$conn->query($query2);
 //    if (!$result) die ("Сбой доступа к базе данных: ".$conn->error());

 //    $rows = $result->num_rows;

 //    for ($i = 0; $i < $rows; $i++) {
 //        $result->data_seek($i);
 //        $row = $result->fetch_array(MYSQLI_NUM);
 //        $check[] = new CLASSUM($row[0], $row[1], $row[2], $row[3]);
 //    }

 //    $newcheck[] = 0;

	// foreach ($check as $item) {
	// 	$res = binarySearch($newcheck, $item->CARD);
	// 	if ($res == 0) {
	// 		$newcheck[] = new CLASSUM($item->DATE, $item->CARD, $item->CHECK, $item->SUMMA);
	// 	} else {
	// 		$newcheck[$res]->SUMMA = $newcheck[$res]->SUMMA + $item->SUMMA;
	// 	}
	// }

	// $report[] = 0;
	// foreach ($bonus as $item) {
	// 	$res = binarySearch($newcheck, $item->CARD);
	// 	if ($res > 0) {
	// 		$report[] = new Report($item->DATE, $item->CARD, $item->CHECK, $item->SUMMA,$newcheck[$res]->SUMMA);
	// 	}
	// }

	// switch ($_POST['sort']) {
	// 	case 'Чек':
	// 		usort($report, function($a, $b){
	// 		    return -($a->CHECK - $b->CHECK);
	// 		});
	// 		break;
	// 	case 'Бонусы':
	// 		usort($report, function($a, $b){
	// 		    return -($a->SUMMA - $b->SUMMA);
	// 		});
	// 		break;
	// 	case 'Покупка':
	// 		usort($report, function($a, $b){
	// 		    return -($a->CHECKSUM - $b->CHECKSUM);
	// 		});
	// 		break;
	// }

	// $resp;

	// foreach ($report as $item) {
	// 	$resp[] = [
 //            "CARD" => $item->CARD,
 //            "CHECK" => $item->CHECK,
 //            "SUMMA" => $item->SUMMA,
 //            "CHECKSUM" => $item->CHECKSUM
 //        ];

 //        $str = json_encode($resp);
	// }

	// echo $str;
?>