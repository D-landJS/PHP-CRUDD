<?php
include('db.php');
include('function.php');
if(isset($_POST["user_id"]))
{
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM videojuego 
		WHERE idVideojuego = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output["video_name"] = $row["video_name"];
		$output["rating"] = $row["rating"];
		$output["price"] = $row["price"];
		// if($row["imagengrande"] != '')
		// {
		// 	$output['user_image'] = '<img src="'.$row["imagengrande"].'" class="img-thumbnail" width="50" height="35" /><input type="hidden" name="hidden_user_image" value="'.$row["imagengrande"].'" />';
		// }
		// else
		// {
		// 	$output['user_image'] = '<input type="hidden" name="hidden_user_image" value="" />';
		// }
	}
	echo json_encode($output);
}
?>