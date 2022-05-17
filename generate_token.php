<?php 

	
	//***Start of Headers*******//
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");
	//***End of Headers*******//



    //***Start of Check Request*******//
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
    	echo json_encode(array('message'=>'Only Post Method Allowed!','status'=>400));
    	die;
    }
    //***End of Check Request********//


	//***Start of Connecting Database*******//
    require_once 'database/database.php';
    $db = new Database();
	//***End of Connecting Database*******//


    //****Start of Check Email and Password******//
    if(empty($_POST['email']))
    {
    	echo json_encode(array('message'=>'Email must be required!','status'=>400));
    	die;
    }

    if(empty($_POST['password']))
    {
    	echo json_encode(array('message'=>'Password must be required!','status'=>400));
    	die;
    }

    //****End of Check Email and Password*******//



    //***Start of Auth User********//
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM `users` WHERE `email`='$email' AND '$password' AND `deleted_at` = 0";
    $result = $db->executeQuery($query);
 	$data = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0)
    {
    	

    	//**Start of Check User Status*******//

    	if($data['status'] != 1)
    	{
    		echo json_encode(array('message'=>'User Account is inactive!','status'=>400));
    	    die;
    	}
    	//**End of Check User Status*******//

    	//***Start of Save  Token*******//
    	$token = generateToken();
    	$query = "UPDATE `users` SET `auth_token` = '$token' WHERE `email`= '$email'";
    	$result = $db->executeQuery($query);
    	if($result)
    	{


    	   echo json_encode(array('token'=>$token,'status'=>200));
    	   die;
    	}else
    	{

    	   echo json_encode(array('message'=>'Failed to save token!','status'=>400,$query));
    	   die;	
    	}
    	//***End of Save Token********//

    }else
    {
    	echo json_encode(array('message'=>'Invalid Email or Password try again!','status'=>400));
    	die;
    }
    //***End of Auth User*********//


	


    //***Start of Generate Token Function********//
    function generateToken()
    {
    	$random = random_bytes(25);
    	return bin2hex($random);
    }
    //***End of Generate Token Function********//

?>