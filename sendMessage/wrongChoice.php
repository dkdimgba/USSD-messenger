<?php include '../connect.php';?>
<?php
$inputJSON = file_get_contents('php://input');
$sql = "INSERT INTO postData (column_request)
VALUES ('$inputJSON')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}

header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );


$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"CONTENT","menuId":"1_1","data":"[\"POLITICS\",\"SPORTS\",\"CULTURE\"]"}';
header('Content-Type: application/json');
echo $response;

?>


<?php include '../disconnect.php';?>