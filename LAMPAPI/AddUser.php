<?php
    $inData = getRequestInfo();
    
    $firstName = $inData["Firstname"];
    $lastName = $inData["Lastname"];
    $username = $inData["Username"];
    $password = $inData["Password"];

	// Verify these credentials
	$conn = new mysqli("localhost", "groupnum_groupnine", "L33tNyne!", "groupnum_COP4331");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
        $sql = 'INSERT INTO Users 
                (ID,FirstName,LastName,Login,Password) 
                VALUES 
                (DEFAULT, "'.$firstName.'", "'.$lastName.'", "'.$username.'", "'.$password.'")';

		if( $result = $conn->query($sql) != TRUE )
		{
			returnWithError( $conn->error );
		}
		$conn->close();
	}
	
	returnWithError("");
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
