<?php
	include_once('config.php');

	define("FLOODPOOL", ".");
	define("FLOODPOOL_LIMIT", 30);
	define("FLOODPOOL_DURATION", 60 * 60 * 24);
	define("FLOODPOOL_AUTOCLEAN", true);

	// Record and check flood.
	// Return true for hit.
	function floodpool_check($id){
		$fp = fopen(FLOODPOOL . DIRECTORY_SEPARATOR . 'fp_' . basename($id), 'a+');
		fwrite($fp, pack('L', time()));
		if(fseek($fp, -4 * FLOODPOOL_LIMIT, SEEK_END) === -1) {
			return false;
		}
		$time = reset(unpack('L', fread($fp, 4)));
		fclose($fp);
		if(time() - $time < FLOODPOOL_DURATION) {
			if(FLOODPOOL_AUTOCLEAN){
				@floodpool_clean();
			}
			return true;
		}
		return false;
	}

	// Clean the pool.
	function floodpool_clean(){
		$handle = opendir(FLOODPOOL);
		while(false!==($entry=readdir($handle))){
			$filename = FLOODPOOL . DIRECTORY_SEPARATOR . $entry;
			if(time() - filectime($filename) > FLOODPOOL_DURATION && substr($entry, 0, 3) === 'fp_'){
				unlink($filename);
			}
		}
		closedir($handle);
	}

	if(floodpool_check($_SERVER['REMOTE_ADDR'])){
		header("HTTP/1.1 429 Too Many Requests");
		exit("Too Many Requests");
	}
	
	$conn = new mysqli($servername, $username, $password, $dbname);
		
	if ($conn->connect_error) {
		die("Connection failed to the database: " . $conn->connect_error);
	}
	
	$method = $_GET["method"];

	if($method == "GET"){
		if(isset($_POST["apiKey"])) {

			$apiKey = $_POST["apiKey"];

            $sqlForUserEmail = "SELECT id, email, apiKey FROM users WHERE apiKey = '" . $apiKey . "'";

            $resultForUserEmail = $conn->query($sqlForUserEmail);
            if ($resultForUserEmail->num_rows > 0) {
                while($row = $resultForUserEmail->fetch_assoc()) {
                    $email = $row["email"];
                }
            }

            $jsonArray = array();

            $stmt = $conn->prepare("SELECT id, snippetName, snippetDescription, snippetDate, snippetContent, ownerEmail, ownerID, snippetType, fileUrl, fileExt, fileSize FROM snippets WHERE ownerEmail=?");

            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row_array['id'] = $row['id'];
                    $row_array['snippetName'] = $row['snippetName'];
                    $row_array['snippetDescription'] = $row['snippetDescription'];
                    $row_array['snippetDate'] = $row['snippetDate'];
                    $row_array['snippetContent'] = $row['snippetContent'];
                    $row_array['ownerEmail'] = $row['ownerEmail'];
                    $row_array['ownerID'] = $row['ownerEmail'];
                    $row_array['snippetType'] = $row['snippetType'];
                    $row_array['fileUrl'] = $row['fileUrl'];
                    $row_array['fileExt'] = $row['fileExt'];
                    $row_array['fileSize'] = $row['fileSize'];

                    array_push($jsonArray, $row_array);
                }
            }

            echo json_encode($jsonArray);
        } else {
            $jsonArray = array();
            $row_array['code'] = 1;
            $row_array['result'] = "ERROR";
            $row_array['result_code'] = "NO_API_KEY_SPECIFIED";
            $row_array['result_desc'] = "YOU MUST HAVE A VALID API KEY TO USE GET FEATURE!";

            array_push($jsonArray, $row_array);

            echo json_encode($jsonArray);
        }
	} else if($method == "ADD"){
		if(isset($_POST["apiKey"])){
			$apiKey = $_POST["apiKey"];
			
			$sqlForUserEmail = "SELECT id, email, apiKey FROM users WHERE apiKey = '" . $apiKey . "'";
		
			$resultForUserEmail = $conn->query($sqlForUserEmail);
			if ($resultForUserEmail->num_rows > 0) {
				while($row = $resultForUserEmail->fetch_assoc()) {
					$email = $row["email"];
					$uid = $row["id"];
				}
			}
			
			$snippetName = $_POST["snippetTitle"];
			$snippetDescription = $_POST["snippetDescription"];
			$snippetContent = $_POST["snippetContent"];
			$snippetDate = date("Y-m-d h:i:s");
			$ownerEmail = $email;
			$snippetType = "notFile";
			$fileUrl = "";

			$sql = "INSERT INTO snippets (snippetName, snippetDescription, snippetDate, snippetContent, ownerEmail, ownerID, snippetType, fileUrl, fileExt, fileSize) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

			$stmt = $conn->prepare($sql);
			$stmt->bind_param("sssssisssi", $snippetName, $snippetDescription, $snippetDate, $snippetContent, $ownerEmail, $uid, $snippetType, $fileUrl, $fileExt, $fileSize);
			$stmt->execute();
			
			$jsonArray = array();
			$row_array['code'] = 0;
			$row_array['result'] = "SUCCESS";
			$row_array['result_code'] = "ADD_SUCCESS";
			$row_array['result_desc'] = "ADDING DATA TO DB WAS SUCCESSFUL!";
			
			array_push($jsonArray, $row_array);
			
			echo json_encode($jsonArray);
			
		} else {
			$jsonArray = array();
			$row_array['code'] = 1;
			$row_array['result'] = "ERROR";
			$row_array['result_code'] = "NO_API_KEY_SPECIFIED";
			$row_array['result_desc'] = "YOU MUST HAVE A VALID API KEY TO USE ADD FEATURE!";
			
			array_push($jsonArray, $row_array);
			
			echo json_encode($jsonArray);
		}
	} else {
		$jsonArray = array();
		$row_array['code'] = 2;
		$row_array['result'] = "ERROR";
		$row_array['result_code'] = "NO_VALID_METHOD_SPECIFIED";
		$row_array['result_desc'] = "THE SPECIFIED METHOD MUST BE EITHER GET OR ADD!";
		
		array_push($jsonArray, $row_array);
		
		echo json_encode($jsonArray);
	}
?>
