<?php include 'connect.php';?>
<?php include 'extractMethods.php';?>
<?php
$inputJSON = file_get_contents('php://input');
$sql = "INSERT INTO table_check (column_check)
VALUES ('$inputJSON')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );

$user=getPhoneNum($input[userId]);
$sql = "select * from table_messages where column_to = '$user' order by column_timestamp desc";

$result = $conn->query($sql);

$content = '';
$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"MENU","data": { "items": [ {"menuContent": "11", "menuOrder": 1, "itemType": "static", "requestURL": "", "screen": { "items": [';
if ($result->num_rows > 0) {
    // output data of each row
	$num_rows = mysql_num_rows($result);
	$rowNum=1;
    while($row = $result->fetch_assoc() && $rowNum<=3) {
		$content.='{ "menuContent": "';
        $content.= "From: " . $row["column_from"]. " - Msg: " . $row["column_message"];
		$content.='", "menuOrder": ';
		$content.=$rowNum;
		$content.=', "itemType": "dynamic", "requestURL": "http://ussd.wc.lt/inbox.php", "screen": {} }';
		if($rowNum<3 && $rowNum<$num_rows)
		$content.=',';
		$rowNum++;
    }
} else {
   $content= '{ "menuContent": "0 Result", "menuOrder": 1, "itemType": "static", "requestURL": "", "screen": {} }';
}
$response.=$content;

$response.='], "menuId": "1_1", "menuHeader": "" } }, { "menuContent": "22", "menuOrder": 2, "itemType": "static", "requestURL": "", "screen": {} } ], "menuId": "1", "menuHeader": "heading1", "menuFooter": "" }}';
header('Content-Type: application/json');
echo $response;
$sql = "INSERT INTO table_check (column_check)
VALUES ('$response')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

?>


<?php include 'disconnect.php';?>