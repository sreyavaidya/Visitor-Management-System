<?php 
include('db_connect_db_new.php');  
session_start();	
if($_SESSION["loggedIn"] == 0)
	 	header("location: index.php");
	$user_ = $_SESSION["user"];

?>
<html>
<head>
<!--  <meta http-equiv = "refresh" content = "10;url= front.php"/>  -->
 <link rel = "stylesheet" href= "BootStrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="navbar3.css">
   <script src= "BootStrap/js/bootstrap.min.js"></script>
  <script src="BootStrap/js/jQuery.min.js"></script>
 <script src="BootStrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="webcam/webmaster/webcam.js"></script>

<style>
html {
  position: relative;
  min-height: 100%;
}body {
  /* Margin bottom by footer height */
  margin-bottom: 40px;
}#head{
	  text-decoration:underline;
}input:required:invalid, input:focus:invalid, input:invalid {
    border-radius: 5px;
    border:soild 1px;

}input:required:valid, input:valid {
    border-radius: 5px;
}input[type='number'] {
    -moz-appearance:textfield;
}input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}.affix {
      top:0;
      width: 100%;
      z-index: 9999 !important;
  }
 </style>

</head>

 <body  onload=display_ct();>
 
  <?php
	$success =0;

  if(!$link)
    die("error". mysqli_link_error());


  if($_SERVER["REQUEST_METHOD"] =="POST"){

  if(empty($_POST["name"]))
	$name_error = "Enter the Name Properly !";
   else
        $name = $_POST["name"];
 
  if(strlen($_POST["cno"]) != 10)
	$cno_error = "Enter Valid Contact number";
  else
	$cno = $_POST["cno"];

  if(empty($_POST["purpose"]))
	$p_error = "Enter Valid Purpose";
  else
	$p = $_POST["purpose"];
date_default_timezone_set("Asia/Kathmandu");
$timein = date("H:i:s");
$rid = rand(100000,900000);
$_SESSION["rid"] = $rid ;

$date = date("Y/m/d");
$comment = $_POST["comment"];
$day = date("d");
$month = date("m");
$year = date("Y");
$meet =$_POST["MeetingTo"];


    
 
  if(empty($name) || empty($cno) || empty($p) || strlen($cno)!=10)
	 $displayError = "You have not entered the details correctly !"; 
  else{
	$sql = "INSERT INTO info_visitor(Name, Contact, Purpose, meetingTo, day, 
                                 month, year, Date, TimeIN, ReceiptID,Status,
				 Comment,registeredBy) VALUES ('$name','$cno','$p',
				 '$meet', '$day', '$month', '$year', '$date',
				 '$timein','$rid','ONLINE', '$comment', 
				 '$user_')";

  if(mysqli_query($link,$sql)) 
	$success =1;   //redirection to the printing page.
  else
	echo "Error: " . $sql . "<br>" . mysqli_error($link);}

//echo "<h4>You will be redirected to the home page after 10 secs !</h4> ";
  if($success == 1)
	header('location: user_profile.php');
   }
?>
	<!--   Navigation Menu   -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" id = "li"><?php echo "Logged in as : ".$user_;?></a>
    </div>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="front.php" id = "li">Home</a></li>
      <li class="active"><a  href="myform.php">Add Visitor</a></li>
      <li ><a  id = "li" href="logoutform.php">Checked Out Visitors</a></li>
      <li><a id = "li" href="query_data.php">View Data</a></li> 
      <li><a id = "li" href="logout.php">Logout</a></li> 
    </ul>
  </div>
</nav>
<!-- time and date script -->

<script type="text/javascript"> 
function display_c(){
var refresh=1000; // Refresh rate in milli seconds
mytime=setTimeout('display_ct()',refresh)
}
function display_ct() {
      var date = new Date();
        var hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
        var am_pm = date.getHours() >= 12 ? "PM" : "AM";
        hours = hours < 10 ? "0" + hours : hours;
        var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
        var seconds = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
        time = hours + ":" + minutes + ":" + seconds + " " + am_pm;
document.getElementById('t1').innerHTML = time;
var x = new Date()
var x1=x.getMonth() + 1+ "/" + x.getDate() + "/" + x.getFullYear();
document.getElementById('t2').innerHTML = x1;
display_c();
 } 
 
</script>


<div style= "float:right; padding-right:8px;padding-top:10px;">
  <p id = "timeDisplay" > Time : <span id="t1"></span>
</p>
  <p id = "dateDisplay"> Date : <span id="t2"></span></p>
</div>	 
<div style="margin-left:110px;padding-bottom:12px">
  <h2>Add Visitor</h2>
  <p id = "redBoxSyndrome"><p>
</div>
  <div class="row" style="margin-left:100px">
   <div class="col-sm-6">
    <form class= "myForm" action= "<?php echo $_SERVER["PHP_SELF"];?>" method= "POST" id ="form">
      <?echo $displayError ;?>
	<div class="row">
         <div class="col-sm-7">
          <div class="form-group">
            <label for="name"> Name :</label> 
  <input autocomplete="off" class="form-control" type= "text" name ="name" placeholder= "Enter Visitor's Name." required id = "name"
         oninvalid="this.setCustomValidity(this.willValidate?'':'Name is required')" onblur="isEmpty('name')" onfocus="onfo('name')"
	 data-toggle="popover" title="Popover Header" data-content="Some content inside the popover" data-trigger = "onfocus"/>
          </div>
         </div>
	
</div>

	

<div class="form-group">
<label for="cno"> Contact No. :</label> <span id = "span" style = "padding-bottom: 5px;float:right;"></span>
 <input autocomplete="off" class="form-control" type="number" id = "ContactInfo" onkeyup = "Ccheck('ContactInfo')" 
	onblur = "isEmpty('ContactInfo')" onfocus = "onfo('ContactInfo')" name="cno" placeholder="Enter Contact Number." 
	required min="1000000000" max = "9999999999" 
        oninvalid="this.setCustomValidity(this.willValidate?'':'Enter correct Contact number please')"
	data-toggle="popover" title="Popover Header" data-content="Some content inside the popover" data-trigger = "onfocus"/>
</div>
<div class="form-group">
<label for ="prps">Purpose :</label> 
<input autocomplete="off" class="form-control" type="text" name="purpose" placeholder="Enter Purpose." required id = "Purpose" 
       oninvalid="this.setCustomValidity(this.willValidate?'':'Enter your Purpose')" maxlength="30" onblur="isEmpty('Purpose')"
       data-toggle="popover" title="Popover Header" data-content="Some content inside the popover" data-trigger = "onfocus" />
</div>
<div class="row">
 <div class="col-sm-7">
  <div class="form-group">
   <label for = "meetingTo">Meeting to :</label>
    <input autocomplete="off" class="form-control" type="text" required name = "MeetingTo" id = "meetingTo" 
	   placeholder="Whom will you meet ?"       oninvalid="this.setCustomValidity(this.willValidate?'':'Whom do you want to meet ?')" maxlength="30"  onblur="isEmpty('meetingTo')"
	   data-toggle="popover" title="Popover Header" data-content="Some content inside the popover" data-trigger = "onfocus"/>
   </div>
  </div>

</div>

 <div class="form-group">
   <label  for = "comment">Comment :</label>  
     <input autocomplete="off" class="form-control" type= "varchar" maxlength="30" name = "comment" height="50px" >
     <br>
 </div>
<div>
 <input id="submitme" type="submit" name="submit_post" 
	class="btn btn-success" value="Submit" onclick="return emptys()"/>
 <input autocomplete="off" id="mydata" type="hidden" name="mydata">
		
  </div>
 </form>
</div>

	</body>
</html>
