<?php include '../connect.php';?>
<?php
$inputJSON = file_get_contents('php://input');
$timeStamp=time();
$sql = "INSERT INTO table_HomeResuestLog (column_RequestHeader,column_Timestamp)
VALUES ('$inputJSON','$timeStamp')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
header('Content-Type: application/json');
$input= json_decode( $inputJSON, TRUE );


$response = '{"sessionId":"' . $input[sessionId] . '","transactionId":"' . $input[transactionId] . '","status":200,"responseType":"MENU","data": { "items": [ {"menuContent": "Hmmmmm", "menuOrder": 1, "itemType": "static", "requestURL": "", "screen": { "items": [ { "menuContent": "", "menuOrder": 1, "itemType": "dynamic", "requestURL": "http://jeffrycopps.in/sendMessage/sendMessage.php", "screen": {}}], "menuId": "1_1", "menuHeader": "" }}, {"menuContent": "Wrong Option", "menuOrder": 2, "itemType": "static", "requestURL": "", "screen": { "items": [ { "menuContent": "", "menuOrder": 2, "itemType": "dynamic", "requestURL": "http://jeffrycopps.in/sendMessage/wrongChoice.php", "screen": {}}], "menuId": "1_2", "menuHeader": "" }}, {"menuContent": "Add contact", "menuOrder": 3, "itemType": "static", "requestURL": "", "screen": { "items": [ { "menuContent": "", "menuOrder": 3, "itemType": "dynamic", "requestURL": "http://jeffrycopps.in/addContact/addContactUI.php", "screen": {}}], "menuId": "1_3", "menuHeader": "" }} , {"menuContent": "Exit", "menuOrder": 4, "itemType": "static", "requestURL": "", "screen": { "items": [ { "menuContent": "", "menuOrder": 4, "itemType": "dynamic", "requestURL": "http://jeffrycopps.in/exit/exit.php", "screen": {}}], "menuId": "1_4", "menuHeader": "" }}], "menuId": "1", "menuHeader": "USSD MESSENGER", "menuFooter": "" }}';
header('Content-Type: application/json');

$sql = "INSERT INTO table_homeResponseLog (column_response)
VALUES ('$response')";
if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
}
echo $response;
?>


<?php include '../disconnect.php';?>