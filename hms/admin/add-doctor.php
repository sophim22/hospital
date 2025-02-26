<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
	header('location:logout.php');
} else {

	if (isset($_POST['submit'])) {
		$docspecialization = $_POST['specialization'];
		$doctorName = mysqli_real_escape_string($con, $_POST['doctorName']);
		$docaddress = mysqli_real_escape_string($con, $_POST['docaddress']);
		$docFees = mysqli_real_escape_string($con, $_POST['docFees']);
		$contactno = mysqli_real_escape_string($con, $_POST['contactno']);
		$docEmail = mysqli_real_escape_string($con, $_POST['docEmail']);
		$password = md5($_POST['password']);

		$sql = mysqli_query($con, "INSERT INTO doctors(specialization, doctorName, address, docFees, contactno, docEmail, password)
                                   VALUES('$docspecialization', '$doctorName', '$docaddress', '$docFees', '$contactno', '$docEmail', '$password')");
		if ($sql) {
			echo "<script>alert('Doctor info added Successfully');</script>";
			echo "<script>window.location.href ='manage-doctors.php'</script>";
		} else {
			echo "<script>alert('$sql');</script>";
		}
	}

?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>Admin | Add Doctor</title>

		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<script type="text/javascript">
			function valid() {
				if (document.adddoc.password.value != document.adddoc.cfpass.value) {
					alert("Password and Confirm Password Field do not match  !!");
					document.adddoc.cfpass.focus();
					return false;
				}
				return true;
			}
		</script>


		<script>
			function checkemailAvailability() {
				$("#loaderIcon").show();
				jQuery.ajax({
					url: "check_availability.php",
					data: 'emailid=' + $("#docEmail").val(),
					type: "POST",
					success: function(data) {
						$("#email-availability-status").html(data);
						$("#loaderIcon").hide();
					},
					error: function() {}
				});
			}
		</script>
	</head>

	<body>
		<div id="app">
			<?php include('include/sidebar.php'); ?>
			<div class="app-content">

				<?php include('include/header.php'); ?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content">
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Add Doctor</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Add Doctor</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">

									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Add Doctor</h5>
												</div>
												<div class="panel-body">

													<form role="form" name="adddoc" method="post" onSubmit="return valid();">
														<div class="form-group">
															<label for="dtsp">
																Doctor Specialization
															</label>
															<select name="specialization" id="dtsp" class="form-control" required="true">
																<option value="">Select Specialization</option>
																<?php $ret = mysqli_query($con, "select * from doctorspecialization");
																while ($row = mysqli_fetch_array($ret)) {
																?>
																	<option value="<?php echo htmlentities($row['id']); ?>">
																		<?php echo htmlentities($row['specialization']); ?>
																	</option>
																<?php } ?>

															</select>
														</div>

														<div class="form-group">
															<label for="doctorName">
																Doctor Name
															</label>
															<input type="text" id="doctorName" name="doctorName" class="form-control" placeholder="Enter Doctor Name" required="true">
														</div>


														<div class="form-group">
															<label for="docaddress">
																Doctor Clinic Address
															</label>
															<textarea name="docaddress" id="docaddress" class="form-control" placeholder="Enter Doctor Clinic Address" required="true"></textarea>
														</div>
														<div class="form-group">
															<label for="docFees">
																Doctor Consultancy Fees
															</label>
															<input type="text" id="docFees" name="docFees" class="form-control" placeholder="Enter Doctor Consultancy Fees" required="true">
														</div>

														<div class="form-group">
															<label for="doccontact">
																Doctor Contact no
															</label>
															<input type="text" id="doccontact" name="contactno" class="form-control" placeholder="Enter Doctor Contact no" required="true">
														</div>

														<div class="form-group">
															<label for="docEmail">
																Doctor Email
															</label>
															<input type="email" id="docEmail" name="docEmail" class="form-control" placeholder="Enter Doctor Email id" required="true" onBlur="checkemailAvailability()">
															<span id="email-availability-status"></span>
														</div>

														<div class="form-group">
															<label for="password">
																Password
															</label>
															<input type="password" id="password" name="password" class="form-control" placeholder="New Password" required="required">
														</div>

														<div class="form-group">
															<label for="cfpass">
																Confirm Password
															</label>
															<input type="password" id="cfpass" name="cfpass" class="form-control" placeholder="Confirm Password" required="required">
														</div>
														<button type="submit" name="submit" id="submit" class="btn btn-o btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>

									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="panel panel-white">


									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- end: BASIC EXAMPLE -->






				<!-- end: SELECT BOXES -->

			</div>
		</div>
		</div>
		<!-- start: FOOTER -->
		<?php include('include/footer.php'); ?>
		<!-- end: FOOTER -->

		<!-- start: SETTINGS -->
		<?php include('include/setting.php'); ?>

		<!-- end: SETTINGS -->
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>

	</html>
<?php } ?>