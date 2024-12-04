<?php  

require_once 'dbconfig.php';
require_once 'models.php';


// INSERT APPLICANT BUTTON

if (isset($_POST['insertApplicantBtn'])) {
    // Validate that all necessary fields are present
    if (
        isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['gender'], 
        $_POST['address'], $_POST['nationality'], $_POST['skills'], $_POST['contact_number'], 
        $_SESSION['username']) // Remove 'added_by' from the POST validation
    ) {
        // Set 'added_by' from the logged-in user's username
        $added_by = $_SESSION['username'];
        
        // Call the insert function
        $insertApplicant = insertNewApplicant(
            $pdo,
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['email'],
            $_POST['gender'],
            $_POST['address'],
            $_POST['nationality'],
            $_POST['skills'],
            $_POST['contact_number'],
            $added_by, // Use the session username for 'added_by'
        );

        // Check the response
        if ($insertApplicant['status'] == "200") {
            $_SESSION['status'] = $insertApplicant['status'];
            $_SESSION['message'] = $insertApplicant['message'];
            header("Location: index.php"); // Redirect to the index page
            exit();
        } else {
            $_SESSION['status'] = $insertApplicant['status'];
            $_SESSION['message'] = $insertApplicant['message'];
            header("Location: index.php"); // Redirect back to the insert form
            exit();
        }
    } else {
        $_SESSION['status'] = "400";
        $_SESSION['message'] = "Please fill in all required fields.";
        header("Location: insert.php");
        exit();
    }
}


// EDIT APPLLICANT BUTTON

if (isset($_POST['editApplicantBtn'])) {
	$editApplicant = editApplicant($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['gender'], $_POST['address'], $_POST['nationality'], $_POST['skills'], $_POST['contact_number'], $_SESSION['username'], $_GET['applicant_id']);

	if ($editApplicant) {
		header("Location: index.php");
		exit();
	}
	else {
		$_SESSION['message'] = "Successfully EDITED";
		$_SESSION['status'] = '400';
		header("Location: index.php");
		exit();
	}
}

// DELETE APPLICANT BUTTON

if (isset($_POST['deleteApplicantBtn'])) {
	$deleteApplicant = deleteApplicant($pdo,$_GET['applicant_id']);

	if ($deleteApplicant) {
		$_SESSION['message'] = $deleteApplicant['message'];
		$_SESSION['status'] = $deleteApplicant['status'];
		header("Location: index.php");
	}
}


// INSERT NEW USER BUTTON

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
			$_SESSION['message'] = $insertQuery['message'];

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: register.php");
			}

		}
		else {
			$_SESSION['message'] = "Make sure the two passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: register.php");
		}

	}

	else {
		$_SESSION['message'] = "Ensure that no input fields are left empty";
		$_SESSION['status'] = '400';
		header("Location: register.php");
	}
}

// LOG IN USER BUTTON

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$usernameFromDB = $loginQuery['userInfoArray']['username'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			header("Location: index.php");
		}

		else {
			$_SESSION['message'] = "Password and Username are invalid";
			$_SESSION['status'] = "400";
			header("Location: login.php");
		}
	}

	else {
		$_SESSION['message'] = "Ensure that no input fields are left empty";
		$_SESSION['status'] = '400';
		header("Location: register.php");
	}

}


// LOG OUT USER BUTTON

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location:  login.php");
}


?>