<?php include 'connect.php';?>
<?php include 'extractMethods.php';?>
<?php

function selectMessages($input,$conn) 
{
	$user=getPhoneNum($input[userId]);
	$sql = "select * from table_messages where column_to = '$user' order by column_timestamp desc";

	$result = $conn->query($sql);
}

function constructMessagesOptions($result)
{
	$content = '';
	if ($result->num_rows > 0) 
	{
	$rowNum=1;
	$numResults = mysql_num_rows($result);
    while($row = $result->fetch_assoc() && $rowNum<=3) 
	{
		$content.= '{"menuContent": "';
		$content.= '"From: "' . $row["column_from"]. '" - Msg: "' . substr($row["column_message"],0,5);
		$content.='", "menuOrder": ';
		$content.=$rowNum;
		$content.=', "itemType": "static", "requestURL": "", "screen": {';
		$content.='"items": [ { "menuContent": "';
		$content.= '"From: "' . $row["column_from"]. '" - Msg: "' . $row["column_message"];
		$content.='", "menuOrder": ';
		$content.=$rowNum++;
		$content.=', "itemType": "static", "requestURL": "", "screen": {}}]';
		$content.='}}';
		if($rowNum<3 &&  $numResults!=$rowNum)
		{$content.=',';}
	}
	
	}
	else
	{
		$content= '{ "menuContent": "0 Result", "menuOrder": 1, "itemType": "static", "requestURL": "", "screen": {} }';
	}
	return $content;
}
$inputJSON = file_get_contents('php://input');
$sql = "INSERT INTO table_check (column_check)
VALUES ('$inputJSON')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );


$result=selectMessages($input,$conn); 
$messagesString = constructMessagesOptions($result);
$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"MENU","data": { "items": ['. $messagesString .'], "menuId": "1", "menuHeader": "heading1", "menuFooter": "" }}';
header('Content-Type: application/json');
echo $response;
$sql = "INSERT INTO table_check (column_check)
VALUES ('$response')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

?>


<?php include 'disconnect.php';?>