<?php include 'connect.php';?>

<?php

	$user='8340283035';
	$sql = "select * from table_messages where column_to = '$user' order by column_timestamp desc";
			$result = $conn->query($sql);
		if ($result->num_rows > 0) 
		{
		echo 'Num of rows: ' . $result->num_rows;
			while($row = $result->fetch_assoc())
			{
				echo "QUESRT: ".$row["column_from"] . $row["column_message"];
			}	
		}
		else
		{
			echo 'No records found';
		}
?>
<?php include 'disconnect.php';?>