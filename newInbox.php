<?php include 'connect.php';?>
<?php include 'extractMethods.php';?>
<?php

function selectMessages($input,$conn) 
{
	$user=getPhoneNum($input[userId]);
	$sql = "select * from table_messages where column_to = '$user' order by column_timestamp desc";

	$result = $conn->query($sql);
	return $result;
}

$inputJSON = file_get_contents('php://input');
$time=time();
$sql = "INSERT INTO table_log (column_1,column_time)
VALUES ('$inputJSON','$time')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );

$result=selectMessages($input,$conn); 

$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"MENU","data": { "items": [';

	$content = '';
	
	if ($result->num_rows > 0) 
	{
		$rowNum=1;
	$numResults = $result->num_rows; //mysql_num_rows($result);
	if($numResults>3)
	{
		$numResults = 3; //maximum 3 rows allowed
	}
while(($row = $result->fetch_assoc()) && $rowNum<=3) 
	{
		$content.= '{"menuContent": "';
		$content.= 'From: ' . $row["column_from"]. ' - Msg: ' . substr($row["column_message"],0,5);
		$content.='", "menuOrder": ';
		$content.=$rowNum;
		$content.=', "itemType": "static", "requestURL": "", "screen": {"items": [
 {
 "menuContent": "33",
 "menuOrder": 1,
 "itemType": "dynamic",
 "requestURL": "http://jeffrycopps.in/newInbox_2.php",
 "screen": {}
 }
 ],
 "menuId": "1_2",
 "menuHeader": ""}';
		$content.='}';
		if($numResults!=$rowNum)
		{$content.=',';}
		
		$rowNum++;
	}
	
	}
	else
	{
		$content= '{ "menuContent": "0 Result", "menuOrder": 1, "itemType": "static", "requestURL": "", "screen": {} }';
	}
 $response.=$content;
 
 $response.= '], "menuId": "1", "menuHeader": "", "menuFooter": "" }, "menuId": "1", "menuHeader": "", "menuFooter": "" }';
header('Content-Type: application/json');
echo $response;
$time=time();
$sql = "INSERT INTO table_log (column_1,column_time)
VALUES ('$response','$time')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}


?>


<?php include 'disconnect.php';?>