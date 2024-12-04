<?php  

require_once 'dbConfig.php';

// GETTING ALL THE APPLICANTS

function getAllApplicants($pdo) {
	$sql = "SELECT * FROM search_applicants_data 
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

// GETTING APPLICANTS BY ID

function getApplicantsByID($pdo, $applicant_id) {
	$sql = "SELECT * from search_applicants_data WHERE applicant_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$applicant_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

// SEARCHING FOR AN APPLICANT

function searchForApplicant($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM search_applicants_data WHERE 
			CONCAT(first_name,last_name,email,gender,
				address,nationality,skills,contact_number,date_added) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

// INSERTING A NEW APPLICANT

function insertNewApplicant($pdo, $first_name, $last_name, $email, $gender, $address, $nationality, $skills, $contact_number, $added_by) {
        $sql = "INSERT INTO search_applicants_data (
                    first_name,
                    last_name,
                    email,
                    gender,
                    address,
                    nationality,
                    skills,
                    contact_number,
                    added_by
                ) VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([
            $first_name,
            $last_name,
            $email,
            $gender,
            $address,
            $nationality,
            $skills,
            $contact_number,
            $added_by
        ]);

        if ($executeQuery) {
            $findInsertedItemSQL = "SELECT * FROM search_applicants_data ORDER BY date_added DESC LIMIT 1";
            $stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
            $stmtfindInsertedItemSQL->execute();
            $getApplicantsByID = $stmtfindInsertedItemSQL->fetch();

            $response = array(
                "status" => "200",
                "message" => "Applicant added successfully!"
            );
        } else {
            $response = array(
                "status" => "400",
                "message" => "Data insertion failed!"
            );
        }
}

// EDITING AN APPLICANT

function editApplicant($pdo, $first_name, $last_name, $email, $gender, $address, $nationality, $skills, $contact_number, $last_updated_by, $applicant_id) {

	$sql = "UPDATE search_applicants_data
				SET first_name = ?,
					last_name = ?,
					email = ?,
					gender = ?,
					address = ?,
					nationality = ?,
					skills = ?,
					contact_number = ?,
					last_updated_by = ?
				WHERE applicant_id = ? 
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $email, $gender, 
		$address, $nationality, $skills, $contact_number, $last_updated_by, $applicant_id]);
}

// DELETING AN APPLICANT

function deleteApplicant($pdo, $applicant_id) {
	$sql = "DELETE FROM search_applicants_data
			WHERE applicant_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$applicant_id]);

	if ($executeQuery) {
		return true;
	}
}

// CHECKING IF THE USER EXISTS

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "The user is not present in the database."
			);
		}
	}

	return $response;

}

// INSERTING A NEW USER

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "The user is successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "The query encountered an error!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "The user already exists!"
		);
	}

	return $response;
}

// GETTING ALL THE USERS

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

?>

