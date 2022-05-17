<?php 


	//***Start of Token Class***//
	class Token
	{

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
		    $headers = getAuthorizationHeader();
		    if (!empty($headers)) {
		        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
		            return $matches[1];
		        }
		    }
		    return null;
		}
		//***End of Get Bearer Token*******//

	}
	//**End of Token CLass******//


?>