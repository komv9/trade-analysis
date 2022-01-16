<?php
    include "connection.php";   
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
	<header class="header" id="myheader">
		<div>
		<b><h3>Trade Analysis</h3></b>
		<form action="/trade.php"><button id="month">Home</button></form>
		<form action="/view.php"><button id="month">View Trade</button></form>
	    </div>
	</header>
  <div class="main">
	<h2 style="text-align: center; margin-top: 5%; padding: 5px;">All Trades</h2>
	<?php
        	$a = "SELECT * FROM `trade` ORDER BY dates DESC;";
            $all = mysqli_query($mysqli, $a);
            if(!$all) {

    	        echo "Failed";
            }
	        if ($all->num_rows>0) {
	            while($row = $all->fetch_assoc()) {
	?>
	<article id="post">
	    <div id="datecol"><b><h2><?php echo $row["dates"];?></h2></b></div>
	    <div id="photocol"><img src="data:image/jpeg;base64,<?php echo $row['previous'];?>" width="100%" height="450"/></div>
	    <div id="textcol"><?php echo $row["btext"];?></div>
      <div class="wrap">
        <div class="control" onclick="location.href='<?php echo "all.php?todelete=".$row['sno'];?>';">Delete</div>
        <div class="control" onclick="location.href='<?php echo "edit.php?toedit=".$row['sno'];?>';">Edit</div>
      </div>
	</article>
	    <?php } }?>
      <?php
        if(isset($_GET['todelete'])) {
            $todelete = $_GET['todelete'];
            $p = "DELETE FROM `trade` WHERE sno=$todelete;";
            $pr = mysqli_query($mysqli,$p);
            if ($pr) {
            //echo $todelete;
            echo "<script>window.location = 'all.php'</script>";
            }
          }
        ?>
    <section>
        <button type="button" class="btn" onclick="window.location.href='/showtoday.php'">Show Today</button>
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
</div>
</body>
</html>