	<?php include 'connect.php';?>
	<?php

	function selectMessages($input,$conn) 
	{
		$user=$input[userId];
		$sql = "select * from table_messages where column_to = '$user' order by column_timestamp desc";
		

		$result = $conn->query($sql);
		return $result;
	}

	function constructMessagesOptions($result)
	{
		$content = '';
		if ($result->num_rows > 0) 
		{
		
		$rowNum=1;
		$numResults = 3;
		while(($row = $result->fetch_assoc()) && $rowNum<=3) 
		{
		if($rowNum==$input[contentSelection])
		{
			
			$content.= 'From: ' . $row["column_from"]. ' - Msg: ' . $row["column_message"];
			
		}
		if($rowNum<3 &&  $rowNum<$result->num_rows)
			{$content.=',';}
			$rowNum++;
		}
		}
		else
		{
			$content= '0 Result';
		}
		return $content;
	}
	$inputJSON = file_get_contents('php://input');
	$sql = "INSERT INTO postData (column_request)
	VALUES ('$inputJSON')";
	if ($conn->query($sql) === TRUE) {
	//    echo "New record created successfully";
	}
	header('Content-Type: application/json');
	$input= json_decode( $inputJSON, TRUE );


	$result=selectMessages($input,$conn); 
	$messagesString = constructMessagesOptions($result);
	$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"CONTENT","data":  "'. $messagesString .'" }';
	header('Content-Type: application/json');
	echo $response;
	$sql = "INSERT INTO postData (column_request)
	VALUES ('$response')";
	if ($conn->query($sql) === TRUE) {
	//    echo "New record created successfully";
	}

	?>


	<?php include 'disconnect.php';?>