<?php require_once 'dbconfig.php'; ?>
<?php require_once 'models.php'; 

if (!isset($_SESSION['username'])) { // If not logged in, redirect to the login page 
    header("Location: login.php"); 
    exit(); }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>INDEX</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include 'navbar.php'; ?>
<div class="container">
	<?php if (isset($_SESSION['message'])) { ?>
		<h1 style="color: green; text-align: center; background-color: ghostwhite; border-style: solid;">	
			<?php echo $_SESSION['message']; ?>
		</h1>
	<?php } unset($_SESSION['message']); ?>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
	<div class="center-container">
		<input type="text" name="searchInput" placeholder="Search here">
		<input type="submit" name="searchBtn">

		<?php if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
			if ($_SESSION['status'] == "200") {
				echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
			} else {
				echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
			}
		}
		unset($_SESSION['message']);
		unset($_SESSION['status']);
		?>
	</div>
	</form>

	<div class="center-container">
		<p><a href="index.php" class="button-like">Clear Search Query</a></p>
		<p><a href="insert.php" class="button-like">Insert New User</a></p>
	</div>

	<table border="1" class="styled-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Gender</th>
				<th>Address</th>
				<th>Nationality</th>
				<th>Skills</th>
				<th>Date Added</th>
				<th>Contact Number</th>
				<th>Added By</th>
				<th>Last Updated</th>
				<th>Last Updated By</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!isset($_GET['searchBtn'])) { ?>
				<?php $getAllApplicants = getAllApplicants($pdo); ?>
				<?php foreach ($getAllApplicants as $row) { ?>
					<tr>
						<td><?php echo $row['applicant_id']; ?></td>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['address']; ?></td>
						<td><?php echo $row['nationality']; ?></td>
						<td><?php echo $row['skills']; ?></td>
						<td><?php echo $row['date_added']; ?></td>
						<td><?php echo $row['contact_number']; ?></td>
						<td><?php echo $row['added_by']; ?></td>
						<td><?php echo $row['last_updated']; ?></td>
						<td><?php echo $row['last_updated_by']; ?></td>
						<td>
							<a href="edit.php?applicant_id=<?php echo $row['applicant_id']; ?>" class="action-btn">Edit</a>    
							<a href="delete.php?applicant_id=<?php echo $row['applicant_id']; ?>" class="action-btn">Delete</a>
						</td>
					</tr>
				<?php } ?>
			<?php } else { ?>
				<?php $searchForApplicant = searchForApplicant($pdo, $_GET['searchInput']); ?>
				<?php foreach ($searchForApplicant as $row) { ?>
					<tr>
						<td><?php echo $row['applicant_id']; ?></td>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['address']; ?></td>
						<td><?php echo $row['nationality']; ?></td>
						<td><?php echo $row['skills']; ?></td>
						<td><?php echo $row['date_added']; ?></td>
						<td><?php echo $row['contact_number']; ?></td>
						<td><?php echo $row['added_by']; ?></td>
						<td><?php echo $row['last_updated']; ?></td>
						<td><?php echo $row['last_updated_by']; ?></td>
						<td>
							<a href="edit.php?applicant_id=<?php echo $row['applicant_id']; ?>">Edit</a>
							<a href="delete.php?applicant_id=<?php echo $row['applicant_id']; ?>">Delete</a>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
		</tbody>
	</table>
</div>

</body>
</html>
