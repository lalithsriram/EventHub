<?php
	require_once("connect.inc.php");

	$search = $_GET["term"];

	if($search != "")
	{
		$query = "SELECT `city` FROM `halls` WHERE `city` LIKE '".$search."%' ";
		$result = $conn->query($query);
		if($result->num_rows>0)
		{
			$res_array = array();
			while($row = $result->fetch_assoc()) 
			{	
				array_push($res_array,array( "label" => $row['city'], "value" => $row['city'] ));	
				   
            }
            echo json_encode($res_array);
		}
		else
		{
			echo json_encode(array("no result"));
		}
	}


?>