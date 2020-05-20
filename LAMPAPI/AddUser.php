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
        if( doesUserExist( $username ) > 0)
        {
            $sql = 'INSERT INTO Users 
                (ID,FirstName,LastName,Login,Password) 
                VALUES 
                (DEFAULT, "'.$firstName.'", "'.$lastName.'", "'.$username.'", "'.$password.'")';

            if( $result = $conn->query($sql) != TRUE )
            {
                returnWithError( $conn->error );
            }
        }
        else
        {
            returnWithError ( "Username already exists. Please choose another." );
        }

        $conn->close();        
	}
	
    returnWithError("");
    
    function doesUserExist( $username )
    {
        $query = "select * FROM Users WHERE username = ?";
        $paramType = "ss";
        $paramArray = array($username);
        $userCount = $this->ds->numRows($query, $paramType, $paramArray);
    
        return $userCount;
    }
	
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
