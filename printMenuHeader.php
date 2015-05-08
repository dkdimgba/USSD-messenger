<?php include 'connect.php';?>
<?php
$inputJSON = file_get_contents('php://input');
$sql = "INSERT INTO RequestHeader (column_data)
VALUES ('$inputJSON')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );


$data=array(
"sessionId"=> $input[sessionId],
"transactionId"=> $input[transactionId],   
"status"=>200,
"responseType"=> "CONTENT",
"menuId"=> $input[menuId],
"data"=> $input[menuHeader]
);
header('Content-Type: application/json');
$response = json_encode($data);

echo $response;
$sql = "INSERT INTO postData (column_request)
VALUES ('$response')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

?>


<?php include 'disconnect.php';?>