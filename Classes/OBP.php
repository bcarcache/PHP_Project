<?php
	include 'OBC.php';

	if ($_POST["fa"]) {
		if (strcmp($_POST["fa"], "deptmun") == 0) {

			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMunicipioDept(" . $_POST['selected_opt'] . ")");
			foreach ($ret as $row) {
				//echo $row["id"];
				//echo $row["nombre"];
				echo $row["id"] . "@" . $row["nombre"] . "@@";
			}
			//echo [
			//    "1" => "First",
			//    "2" => "Second",
			//];
			//echo $array;
		}
	}
?>