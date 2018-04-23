<?php
      $reqData= file_get_contents("php://input");
      $params = explode("###", $reqData);
      $reqBody=$params[0];
      $testMode=$params[1]; 	  		
      $tempstr = date('YmdGis') . "1";
      $request_id = md5($tempstr);

	if($testMode=='YES') {
		$url="https://pilot-payflowpro.paypal.com";
	}else {
		$url="https://payflowpro.paypal.com";	
	}
      
      $headers[] = "Content-Type: text/namevalue"; //or maybe text/xml
      $headers[] = "X-VPS-VIT-Client-Type: PHP/cURL";  // What you are using    
      $headers[] = "X-VPS-Request-ID: " . $request_id;
      
      //print_r($headers);
      $user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
      try {
      $ch = curl_init(); 
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      //curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
      curl_setopt($ch, CURLOPT_HEADER, 1); // tells curl to include headers in response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
      curl_setopt($ch, CURLOPT_TIMEOUT, 45); // times out after 45 secs
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // this line makes it work under https
      curl_setopt($ch, CURLOPT_POSTFIELDS, $reqBody); //adding POST data
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2); //verifies ssl certificate
      curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE); //forces closure of connection when done
      curl_setopt($ch,CURLOPT_PORT, 443); 
      curl_setopt($ch, CURLOPT_POST, 1); //data sent as POST 
    
      $result = curl_exec($ch);
      curl_close($ch);
	
      }catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}
      $result = substr($result, strpos($result, 'RESULT'), strlen($result));
      echo $result;
      
		
?>
