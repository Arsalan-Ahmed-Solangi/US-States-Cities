<?php 
    
	
	//***Start of Headers*******//
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	//***End of Headers*******//


    //***Start of Connecting Database*******//
    require_once 'database/database.php';
    $db = new Database();
    //***End of Connecting Database*******//


    //****Start of Check Token******//
    require_once 'require/token.php';
    $token = new Token();
    $verify = $token->verifyToken();
    //****End of Check Token********//


    //***Start of GET Request*******//
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
    	
        //***Start of Check Single or All Users******//
        if(isset($_GET['user_id']) && !empty($_GET['user_id']))
        {

            $query = "SELECT * FROM `users` WHERE `deleted_at` ='0' AND `user_id`=".$_GET['user_id'];
            $result = $db->executeQuery($query);
           
            if(mysqli_num_rows($result) > 0)
            {
                echo json_encode(array('data'=>mysqli_fetch_all($result,MYSQLI_ASSOC),'status'=>200));
            }else
            {
                echo json_encode(array("message"=>"No User Found","status"=>400));
            }


        }else
        {
            $query = "SELECT * FROM `users` WHERE `deleted_at` ='0'";
            $result = $db->executeQuery($query);
           
            if(mysqli_num_rows($result) > 0)
            {
                echo json_encode(array('data'=>mysqli_fetch_all($result,MYSQLI_ASSOC),'status'=>200));
            }else
            {
                echo json_encode(array("message"=>"No Users Found","status"=>400));
            }
                
        }
        //***End of Check Single or All Users*******//

    }
    //***End of GET Request********//


    //**Start of Delete Request******//
    //**End of Delete Request******//




    

?>