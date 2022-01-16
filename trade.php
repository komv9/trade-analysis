<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trade Sheet</title>
	<link rel="stylesheet" href="trade.css"/>
	<link rel="stylesheet" href="date.css"/>
	<script type="text/javascript" src="trade.js"></script>
</head>
<body>
	<?php
        $month = date('F');
        $days = date('t');
        $today =date('j');
        $mno =date('m');
        $year =date('Y');
        include "connection.php";
        if(isset($_POST["upload"])) {
	        $dates = $_POST["dates"];
            $newbtext = $_POST["newbtext"];
            $profit = $_POST["profit"];
            $newfile1 = $_FILES["newfile1"]["tmp_name"];
            $newfile1 = base64_encode(file_get_contents(addslashes($newfile1)));
            $s = "INSERT INTO `trade`(`dates`, `previous`, `btext`, `profit`) VALUES ('$dates','$newfile1','$newbtext','$profit');";
            $new = mysqli_query($mysqli, $s);
            if(!$new) {
    	        echo "Failed";
            }
            echo '<script type="text/javascript">uploadnew();</script>';
        }
	?>
	<header  class="header" id="myheader">
		<div>
		<b><h3>Trade Analysis</h3></b>
		<button name="all" onclick="window.location.href='/all.php'" id="month">All Trades</button>
		<form action="/view.php"><button id="month">View Trade</button></form>
		<form action="/month.php"><button id="month"><?php echo $month; ?></button></form>
	    </div>
	</header>
	<div class="main">
		<h2 style="text-align: center; margin-top: 5%; padding: 5px;"><?php echo $month;?></h2>
	<div id="calendar">
		<?php
            for ($i=1; $i <= $today; $i++) { 
        ?>
        <div onclick="location.href='<?php echo "calendar.php?id=".$i;?>';" class="date" id="<?php echo $i;?>">
        <div class="day">Date<?php echo $i;?></div>
        <div class="data">
        	<?php
        	    $day = '0'.$i;
                $j=1;
                $all = "SELECT * FROM `trade` WHERE DAY(dates)=$day AND MONTH(dates)=$mno AND YEAR(dates)=$year;";
                $qall = mysqli_query($mysqli, $all);
                if ($qall->num_rows>0) {
                	while($rowk = $qall->fetch_assoc()) {
                	echo "jvalue".$j;
                	echo "<br>btext".$rowk['btext']."<br>";
                	echo "profit".$rowk['profit']."<br>";
                	$j=$j+1;
                    }
                }

        	?>
        <?php
        $day = '0'.$i;
        $fetch = "SELECT COUNT(dates) FROM `trade` WHERE DAY(dates)=$day;";
        $res = mysqli_query($mysqli, $fetch);
        $nor = mysqli_fetch_array($res);
        $tnor = $nor[0];
        echo $tnor;
        ?>
        </div>
        </div>
        <?php }?>
    </div>
    <section>
        <button type="button" class="btn" onclick="window.location.href='/showtoday.php'">Show Today</button>
        <button type="button" onclick="addtoday()" class="btn">Add Today</button>
        <button type="button" onclick="addnew()" class="btn">Add Trade</button>
    </section>
    <div id="todayform" class="form">
          <form action="/showtoday.php" method="post" enctype="multipart/form-data" id="todayp">
              <h1>Add Today Data</h1>
              <br><br>
              <label for="tfile1"><b>Before Shot</b></label>
              <input type="file" name="tfile1" id="tfile1" required>
              <br>
              <label for="tbtext"><b>Before Text</b></label>
              <br>
              <input type="text" placeholder="Enter before text data" name="tbtext" id="tbtext" required>
              <br>
              <label for="gain"><b>Profit</b></label>
              <br>
              <input type="text" placeholder="Enter before text data" name="gain" id="gain" required>
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
              <label for="profit"><b>Before Text</b></label>
              <br>
              <input type="text" placeholder="Enter profit" name="profit" id="profit" required>
              <br>
              <button type="submit" name="upload">Upload</button>
              <br>
              <button type="button" onclick="closenewform()">Close</button>
           </form>
        </div>
 <br><br><br><br>   
</div>   
</body>
</html>