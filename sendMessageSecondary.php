<?php include 'connect.php'; //DB connections ?> 
<?php include 'extractMethods.php'; //Extract msg and phone num from input string?> 
<?php

//Methods
function getReceiverPhoneNumber($from,$conn)
{
	
	$query = "select * FROM table_buffer where column_from = '$from'";
	$result = $conn->query($query);
	$row = $result->fetch_assoc();
	$to = $row['column_to'];
	$file='log.txt';
	file_put_contents($file, "John", FILE_APPEND | LOCK_EX);
	file_put_contents($file, $to, FILE_APPEND | LOCK_EX);
	file_put_contents($file, $row, FILE_APPEND | LOCK_EX);
	return $to;
	
}

$inputJSON = file_get_contents('php://input'); //Getting request header contents 

header('Content-Type: application/json'); //Setting content type before decoding. I dont think its needed here. :p
$input= json_decode( $inputJSON, TRUE ); //decoding input string

$from=getPhoneNum($input[userId]); //extract phone number[sender] from the request JSON
$to=getReceiverPhoneNumber($from,$conn); //This method selects from the buffer table which has (from,to) received in the prev page
$msg=getMessage($input[contentSelection]); //extract input text message
$timeStamp=time(); //get timestamp for ordering the messages Last sent first
$sql = "INSERT INTO table_messages(column_from,column_to,column_message,column_timestamp)
VALUES ('$from','$to','$msg','$timeStamp')"; //Insert into table messages (from, to, message, timestamp)
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

//Acknowledgement [JSON request expects a response]
$data=array(
"sessionId"=> $input[sessionId],
"transactionId"=> $input[transactionId],   
"status"=>200,
"responseType"=> "CONTENT",
"menuId"=> $input[menuId],
"data"=> '["POLITICS","SPORTS","CULTURE"]'
);
header('Content-Type: application/json');
$response = json_encode($data); 

echo $response; //This is not needed, but just acts as an acknowledgement
$sql = "INSERT INTO postData (column_request)
VALUES ('$response')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

?>


<?php include 'disconnect.php';?>