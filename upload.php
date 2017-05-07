<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php require_once 'head.php'; ?>
</head>
<body>
<?php
require_once 'nav.php';
$result = -1;

// Only admin users can upload files.
if (!logged_in() || $_SESSION['usertype'] != "admin") {
	header("location: index.php");
} else if ($_POST) {
	// Handle all kinds of errors due to file upload.
	if ($_FILES['file']['error'] > 0) {
		if ($_FILES['file']['error'] == 1 || $_FILES['file']['error'] == 2) {
			$result = 1;
		} else if ($_FILES['file']['error'] == 3 || $_FILES['file']['error'] == 4) {
			$result = 2;
		} else {
			$result = 4;
		}
	} else if ($_FILES['file']['type'] != "application/pdf") {
		// Restrain the file type to be only .pdf files.
		$result = 2;
	} else {
		// Record that the upload is successful.
		$result = 0;

		// Save the file locally and keep a record in the database.
		file_upload($_FILES['file'], $_POST['fileName'], $_POST['author'], $_POST['description']);

		// Re-direct to the homepage.
		header("location: index.php");
	}
}
?>

<h1>Upload Files<small> (For Admin only)</small></h1>

<div class="container">
	<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offse-2 col-lg-8 col-lg-offset-2">
		<form role="form" method="post" action="upload.php" enctype="multipart/form-data">
			<p style="color: red;">
				<?php
				if ($result == 1) {
					echo "File size error: You are only allowed to upload files not larger than 5MB.";
				} else if ($result == 2) {
					echo "Network error: The upload process has been cancelled or has not finished.";
				} else if ($result == 3) {
					echo "File type error: You are only allowed to upload .pdf files.";
				} else if ($result > 0) {
					echo "Unknown error. Please contact your Avenger.";
				}
				?>
			</p>

			<!-- Define the maximum file size here, a little bit smaller than 5MB (which is 5242880). -->
			<input type="hidden" name="MAX_FILE_SIZE" value="5242800">

			<div class="form-group">
				<label for="fileName">File Name</label>
				<input type="text" name="fileName" class="form-control" id="fileName" placeholder="Type the name of the file" accesskey="n" tabindex="1" required autofocus>
			</div>

			<div class="form-group">
				<label for="author">Author</label>
				<input type="text" name="author" class="form-control" id="author" placeholder="Type author" accesskey="a" tabindex="2">
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<input type="text" name="description" class="form-control" id="description" placeholder="Type the description of the file" accesskey="d" tabindex="3">
			</div>

			<div class="form-group">
				<label for="file">Select file to upload</label>
				<input type="file" name="file" class="form-control" id="file" placeholder="Select file to upload" accesskey="f" tabindex="4" required>
			</div>

			<button type="submit" class="btn btn-success">Upload</button>

			<button class="btn btn-primary" onclick="window.location.href='index.php'">Cancel</button>
		</form>
	</div>
</div>
<br><br><br><br>

<?php
require_once 'footer.php';
?>
</body>
</html>