<?php
    //echo "Komal";
    $today = date("Y-m-d");
    include "connection.php";
    if(isset($_POST["today"])) {
        	$dates = date("Y-m-d");
        	$tbtext = $_POST['tbtext'];
        	$tfile1 = $_FILES['tfile1']['tmp_name'];
        	$tfile1 = base64_encode(file_get_contents(addslashes($tfile1)));
        	$t = "INSERT INTO `trade`(`dates`, `previous`, `btext`) VALUES ('$dates','$tfile1','$tbtext');";
            $tupload = mysqli_query($mysqli, $t);
            if(!$tupload) {

    	        echo "Failed";
            }
           /*else {
    	        echo "Upload successful";
            }*/

        }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trade Sheet</title>
	<link rel="stylesheet" type="text/css" href="/trade.css">
  <script type="text/javascript" src="trade.js"></script>
</head>
<body>
    <?php
        $month = date('F');
        $days = date('t');
        $today =date('j');
        include "connection.php";
        if(isset($_POST["upload"])) {
	        $dates = $_POST["dates"];
            $newbtext = $_POST["newbtext"];
            $newfile1 = $_FILES["newfile1"]["tmp_name"];
            $newfile1 = base64_encode(file_get_contents(addslashes($newfile1)));
            $s = "INSERT INTO `trade`(`dates`, `previous`, `btext`) VALUES ('$dates','$newfile1','$newbtext');";
            $new = mysqli_query($mysqli, $s);
            if(!$new) {
    	        echo "Failed";
            }
            echo '<script type="text/javascript">uploadnew();</script>';
        }

	?>
	<header class="header" id="header">
		<div>
		<b><h3>Trade Analysis</h3></b>
		<form action="/trade.php"><button id="month">Home</button></form>
		<form action="/view.php"><button id="month">View Trade</button></form>
    <button name="all" onclick="window.location.href='/all.php'" id="month">All Trades</button>
    <form action="/month.php"><button id="month"><?php echo $month; ?></button></form>
	    </div>
	</header>
  <div class="main">
	<h2 style="text-align: center; margin-top: 5%; padding: 5px;">Today</h2>
	<!--<h3 style="margin-left: 2%; margin-top: 1%"></h3>-->
	<?php 
	    $q = "SELECT * FROM `trade` WHERE DATE(dates)=CURDATE();";
	    $show = mysqli_query($mysqli, $q);
            if(!$show) {

    	        echo "Failed";
            }
           /*else {
    	        echo "Upload successful";
            }*/
        if ($show->num_rows>0) {
	        while($row = $show->fetch_assoc()) {
	    ?>
	    <article id="post">
	    	<div id="datecol"><b><h2><?php echo $row["dates"];?></h2></b></div>
	    	<div id="photocol"><img src="data:image/jpeg;base64,<?php echo $row['previous'];?>" width="100%" height="450"/></div>
	    	<div id="textcol"><?php echo $row["btext"];?></div>
        <br>
        <div class="wrap">
        <div class="control" onclick="location.href='<?php echo "showtoday.php?todelete=".$row['sno'];?>';">Delete</div>
        <div class="control" onclick="location.href='<?php echo "edit.php?toedit=".$row['sno'];?>';">Edit</div>
      </div>
	    </article>
	    <?php } } ?>
      <?php
        if(isset($_GET['todelete'])) {
            $todelete = $_GET['todelete'];
            /*$todelete = strtotime($todelete);
            $dday = date('j', $todelete);
            echo $dday;
            $dmonth = date('m', $todelete);
            echo $dmonth;
            $dyear = date('Y', $todelete);
            echo $dyear;*/
            $p = "DELETE FROM `trade` WHERE sno=$todelete;";
            $pr = mysqli_query($mysqli,$p);
            if ($pr) {
            //echo $todelete;
            echo "<script>window.location = 'showtoday.php'</script>";
            }
          }
        ?>

	    <section>
        <button type="button" onclick="window.location.href='/showtoday.php'" class="btn">Show Today</button>
        <button type="button" onclick="addtoday()" class="btn">Add Today</button>
        <button type="button" onclick="addnew()" class="btn">Add Trade</button>
        </section>
        <br><br><br><br>
        <div id="todayform" class="form">
          <form action="/showtoday.php" method="post" enctype="multipart/form-data">
              <h1>Add Today Data</h1>
              <br><br>
              <label for="tfile1"><b>Before Shot</b></label>
              <input type="file" name="tfile1" id="tfile1" required>
              <br>
              <label for="tbtext"><b>Before Text</b></label>
              <br>
              <input type="text" placeholder="Enter before text data" name="tbtext" id="tbtext" required>
              <br>
              <button type="submit" name="today" onclick="uploadtoday()">Upload</button>
              <br>
              <button type="button" onclick="closetodayform()">Close</button>
           </form>
        </div>
    <div id="newform" class="form">
          <form action="/trade.php" method="post" enctype="multipart/form-data">
              <h1>Add New Date Data</h1>
              <br><br>
              <label for="dates">Date:</label>
              <input type="date" id="dates" name="dates" required>
              <br>
              <label for="newfile1"><b>Before Shot</b></label>
              <input type="file" name="newfile1" id="newfile1">
              <br>
              <label for="newbtext"><b>Before Text</b></label>
              <br>
              <input type="text" placeholder="Enter before text data" name="newbtext" id="newbtext" required>
              <br>
              <button type="submit" name="upload">Upload</button>
              <br>
              <button type="button" onclick="closenewform()">Close</button>
           </form>
        </div>
        <div id="tradeform" class="form">
          <form action="" method="post" enctype="multipart/form-data">
              <h1>Add Today Data</h1>
              <br><br>
              <label for="tfile1"><b>Before Shot</b></label>
              <input type="file" name="tfile1" id="tfile1" required>
              <br>
              <label for="tbtext"><b>Before Text</b></label>
              <br>
              <input type="text" placeholder="Enter before text data" name="tbtext" id="tbtext" required>
              <br>
              <button type="submit" name="trade" onclick="addtradedata()">Upload</button>
              <br>
              <button type="button" onclick="closetrade()">Close</button>
           </form>
        </div>

</div>
</body>
</html>