<!-- This file contains a PHP self-processing form used to demonstrate PHP error handling
concepts described in class -->

<!DOCTYPE html>

<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST['calculate'])) {
			
			$value = $_POST['valueInteger'];
			
			// Checking if the input is a valid integer and not zero
			if ((filter_var($value, FILTER_VALIDATE_INT) == true) && ($value!=0)) {
				$msg = "The result is ".(100/$value);
			} else {
				$value=1; // If $value is "0", empty($value) will return true and $msg will not be printed (line 67)
				$msg = "Invalid input!";
			}		
		}
		else if (isset($_POST['connectDb'])){
			$servername = "localhost";
			$username = "root";
			$password = "";
			$value = $_POST['valueDbName'];
			
			/* In a procedural approach we can't avoid the error generated by new mysqli() to be displayed
			 * To handle this error we would need to use try/catch exception handling constructs (not in teh scope of this course)
			 * We can however anyway check the status of $conn and display some additional message to the user
			 */
			$conn = new mysqli($servername, $username, $password, $value); // Connecting to the database
			
			if ($conn->connect_error){
				$msg = "There was a problem connecting to the database. Please, check if the db name is correct";
			}
			else{
				$msg = "You are now connected to the database.";
			}
		}
		else { 
			$value = ''; // Setting an empty value
		}
    }
?>

<!-- HTML FORM. This section of the file defines the HTML form -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Validation and sanitization examples</title>
</head>
 
<body>

	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		Divide 100 by (or enter "0" to produce an error):
		<input type="text" name="valueInteger">
		<input type="submit" name="calculate" value="Divide"><br><br>

		Enter the name of a database you want to connect to:
		<input type="text" name="valueDbName">
		<input type="submit" name="connectDb" value="Connect to db"><br><br>

	</form>

	<br>
	Result: <br><?php echo !empty($value)?$msg:'';?>
  	<br><br>
</body>
</html>
