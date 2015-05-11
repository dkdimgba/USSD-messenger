<?php include 'connect.php'; //DB connections ?> 
<?php include 'extractMethods.php'; //Extract msg and phone num from input string?> 
<?php
$inputJSON = file_get_contents('php://input'); //Getting request header contents 

$sql = "INSERT INTO table_check(column_check) VALUES ('$inputJSON')"; //Insert request JSON string  into table_check
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
header('Content-Type: application/json'); //Setting content type before decoding. I dont think its needed here. :p
$input= json_decode( $inputJSON, TRUE ); //decoding input string

$from=getPhoneNum($input[userId]); //extract phone number[sender] from the request JSON
$to=getPhoneNum($input[contentSelection]); //extract phone number[receiver] from the request JSON


$sql = "REPLACE INTO table_buffer(column_from,column_to)
VALUES ('$from','$to')"; //Replace works exactly like  insert if the row doesnt exist, else updates with new values
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}


$data=array(
"sessionId"=> $input[sessionId],
"transactionId"=> $input[transactionId],   
"status"=>200,
"responseType"=> "CONTENT",
"menuId"=> $input[menuId],
"data"=> '["ACK"]'
);
header('Content-Type: application/json');
$response = json_encode($data); 

echo $response; //This is not needed, but just acts as an acknowledgement

?>


<?php include 'disconnect.php';?>