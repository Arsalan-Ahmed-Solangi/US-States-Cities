<?php 
	
	//***Start of Database******//
	require_once 'database/database.php';
	//***End of Database*******//
	
	//***Start of Token Class***//
	class Token
	{

		//***Start of Variables*****//
		private $db = null;
		//**End of Variables*******//


		//**Start of Constructor******//
		public function __construct()
		{
			$this->db = new Database();
		}
		//**End of Constructor******//

		//***Start of Get Authorization Header******//
		function getAuthorizationHeader(){


		    $headers = null;
		    if (isset($_SERVER['Authorization'])) {
		        $headers = trim($_SERVER["Authorization"]);
		    }
		    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { 
		        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		    } elseif (function_exists('apache_request_headers')) {
		        $requestHeaders = apache_request_headers();
		        
		        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
		        if (isset($requestHeaders['Authorization'])) {
		            $headers = trim($requestHeaders['Authorization']);
		        }
		    }
		    return $headers;
		}
		//***End of Get Authorization Header*******//


		//***Start of Get Bearer Token*******//
		function getBearerToken() {
		    $headers = $this->getAuthorizationHeader();
		    if (!empty($headers)) {
		        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
		            return $matches[1];
		        }
		    }
		    return null;
		}
		//***End of Get Bearer Token*******//


		//**Start of Verify Token*******//
		public function verifyToken()
		{

			$token = $this->getBearerToken();
			$query = "SELECT * FROM `users` WHERE `auth_token` = '$token'";
			
		    $result = $this->db->executeQuery($query);

		    if(mysqli_num_rows($result) == 0)
		    {
		    	echo json_encode(array('message'=>'Token is invalid or expired!','status'=>400));
		    	die;
		    }
		}
		//**End of Verify Token********//

	}
	//**End of Token CLass******//


?>