<?php include 'connect.php';?>
<?php
$inputJSON = file_get_contents('php://input');
header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );


$data=array(
"sessionId"=> $input[sessionId],
"transactionId"=> $input[transactionId],   
"status"=>200,
"responseType"=> "CONTENT",
"menuId"=> $input[menuId],
"data"=> '["INBOX UI"]'
);
header('Content-Type: application/json');
$response = json_encode($data);

echo $response;

?>


<?php include 'disconnect.php';?>