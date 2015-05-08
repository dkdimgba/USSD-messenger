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
$sql = "INSERT INTO table_log(column_1,column_time)
VALUES ('$inputJSON','$time')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );

$to=getPhoneNum($input[userId]);
$contentSelection=$input[contentSelection];
$result=selectMessages($input,$conn); 

$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"CONTENT","data": "';

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
		if($rowNum==$contentSelection){
		$content.= 'From: ' . $row["column_from"]. ' \n Msg: ' . $row["column_message"];
		}
		$rowNum++;
	}
	
	}
	else
	{
		$content= 'Invalid selection';
	}
 $response.=$content;
 $response.='", "menuId": "3", "menuHeader": "--Inbox--", "menuFooter": "" }';
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