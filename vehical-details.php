<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
$fromdate=$_POST['fromdate'];
$todate=$_POST['todate']; 
$carno=$_POST['carno'];
$useremail=$_SESSION['login'];
$status=1;
$pid=$_GET['pid'];
$bookingno=mt_rand(100000, 999999);


$ret="SELECT * FROM tblbooking where (:fromdate BETWEEN date(FromDate) and date(ToDate) || :todate BETWEEN date(FromDate) and date(ToDate) || date(FromDate) BETWEEN :fromdate and :todate)and carno=:carno";


$query1 = $dbh -> prepare($ret);
$query1->bindParam(':carno',$carno, PDO::PARAM_STR);
$query1->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query1->bindParam(':todate',$todate,PDO::PARAM_STR);
$query1->execute();


$results1=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount()==0)
{

$sql="INSERT INTO  tblbooking(BookingNumber,EmailId,pid,FromDate,ToDate,carno,status) VALUES(:bookingno,:useremail,:pid,:fromdate,:todate,:carno,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookingno',$bookingno,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':carno',$carno,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();


$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{   
  
$sql = "SELECT lots,booked from tblbrands where tblbrands.id=:pid";
$query = $dbh -> prepare($sql);
$query->bindParam(':pid',$pid, PDO::PARAM_STR);
$query->execute();
$row=$query->fetch();
 
 $lots1=$row[0];
 $booked1=$row[1];

$nlots=$lots1-1;
$nbooked=$booked1+1; 

$sql1="UPDATE tblbrands set lots=:nlots,booked=:nbooked where tblbrands.id=:pid";
$query = $dbh->prepare($sql1);

$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':nlots',$nlots,PDO::PARAM_STR);
$query->bindParam(':nbooked',$nbooked,PDO::PARAM_STR);
$query->execute();

	echo "<script>alert('Booking successfull.');</script>";
	echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
	}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
echo "<script type='text/javascript'> document.location = 'car-listing.php'; </script>";
} 

}else{
 echo "<script>alert('Car already booked for these days');</script>"; 
 echo "<script type='text/javascript'> document.location = 'car-listing.php'; </script>";
}

}

?>


<!DOCTYPE HTML>
<html lang="en">
<head>

<title>Online Car Parking | Vehicle Details</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Listing-Image-Slider-->


<?php 
// gt prk id
$pid=intval($_GET['pid']);

// print_r($pid);
// exit();


$sql = "SELECT * tblbrands where tblbrands.id=:pid";
$query = $dbh -> prepare($sql);
$query->bindParam(':pid',$pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$_SESSION['brndid']=$result->bid;  
?>  

<section id="listing_img_slider">
 <!-- pic ya the parking area -->
	<div><img src="admin/img/parkimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/parkimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
	<?php if($result->Vimage3=="")
{

}  else {
	?>
	<div><img src="admin/img/parkimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
	<?php } ?>
</section>
<!--/Listing-Image-Slider-->


<!--Listing-detail-->
<section class="listing-detail">
	<div class="container">
		<div class="listing_detail_head row">
			<div class="col-md-9">
				<!-- park name and location  free lots and booked lots. first class -->
				<h2><?php echo htmlentities($result->ParkName);?>  <?php echo htmlentities($result->location);?></h2>
			</div>
			<div class="col-md-3">
				<div class="price_info">
					<p>$<?php echo htmlentities($result->PricePerDay);?> </p>Per parking Day
				 
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9">
				<div class="main_features">
					<ul>
					
						<li> <i class="fa fa-cape" aria-hidden="true"></i>
							<h5><?php echo htmlentities($result->FreeLots);?></h5>
							<p>Free Lots</p>
						</li>
						<li> <i class="fa fa-ksh" aria-hidden="true"></i>
							<h5><?php echo htmlentities($result->PricePerDay);?>ksh</h5>
							<p>Charges per day</p>
						</li>
			 
						<li> <i class="fa fa-close" aria-hidden="true"></i>
							<h5><?php echo htmlentities($result->BookedLots);?></h5>
							<p>reserved</p>
						</li>
					</ul>
				</div>
				<div class="listing_more_info">
					<div class="listing_detail_wrap"> 
						<!-- Nav tabs -->
						<ul class="nav nav-tabs gray-bg" role="tablist">
							<li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle Overview </a></li>
					
							<li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Characteristics</a></li>
						</ul>
						
						<!-- Tab panes -->
						<div class="tab-content"> 
							<!-- vehicle-overview -->
							<div role="tabpanel" class="tab-pane active" id="vehicle-overview">
								
								<p><?php echo htmlentities($result->VehiclesOverview);?></p>
							</div>
							
							
							<!-- Accessories -->
							<div role="tabpanel" class="tab-pane" id="accessories"> 
								<!--Accessories-->
								<table>
									<thead>
										<tr>
											<th colspan="2">Characteristics</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Parking Shade</td>
<?php if($result->shaded==yes)
{
?>
											<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?> 
	 <td><i class="fa fa-close" aria-hidden="true"></i></td>
	 <?php } ?> </tr>

<tr>
<td>Govt Security Officers</td>
<?php if($result->AntiLockBrakingSystem==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>

<?php } ?>
</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					
				</div>
<?php }} ?>
	 
			</div>
			
			<!--Side-Bar-->
			<aside class="col-md-3">
			<!-- social media share link of our parks -->
				<div class="share_vehicle">
					<p>Share: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
				</div>
				<div class="sidebar_widget">
					<div class="widget_heading">
						<h5><i class="fa fa-envelope" aria-hidden="true"></i>Book Parking Lot Now</h5>
					</div>
					<form  action="mpesa.php">
						<div class="form-group">
							<label>Car No:</label>
							<input type="text" class="form-control" name="carno" placeholder="Car Number" required>
						</div>
						<div class="form-group">
							<label>From Date:</label>
							<input type="date" class="form-control" name="fromdate" placeholder="From Date" required>
						</div>
							<div class="form-group">
							<label>Time:</label>
							<input type="time" class="form-control" name="fromtime" placeholder="time from" required>
						</div>
						<div class="form-group">
							<label>To Date:</label>
							<input type="date" class="form-control" name="todate" placeholder="To Date" required>
						</div>
							<div class="form-group">
							<label>Time:</label>
							<input type="time" class="form-control" name="totime" placeholder="time to" required>
						</div>

						<!-- cant book while loged off -->
					<?php if($_SESSION['login'])
							{?>
							<div class="form-group">
								<input type="submit" class="btn"  name="submit" value="Book Now">
							</div>
							<?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>

							<?php } ?>
					</form>
				</div>
			</aside>
			<!--/Side-Bar--> 
		</div>
		
		<div class="space-20"></div>
		<div class="divider"></div>
		

		
	</div>
</section>
<!--/Listing-detail--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>