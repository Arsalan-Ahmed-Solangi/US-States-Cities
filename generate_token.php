<?php 

	
	//***Start of Headers*******//
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
	//***End of Headers*******//




	//***Start of Connecting Database*******//
    require_once 'database/database.php';
    $db = new Database();
	//***End of Connecting Database*******//


    //****Start of Check Email and Password******//
    if(empty($_POST['email']))
    {
    	return json_encode(array('message'=>'Email must be required!','status'=>'200'));
    }

    if(empty($_POST['password']))
    {
    	return json_encode(array('message'=>'Password must be required!','status'=>'200'));
    }

    //****End of Check Email and Password*******//



    //***Start of Auth User********//
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM `users` WHERE `email`='$email' AND '$password'";
    $result = $db->execute($query);

    if($result->num_rows())
    {
    	echo "Yess";
    }
    //***End of Auth User*********//


	


?>