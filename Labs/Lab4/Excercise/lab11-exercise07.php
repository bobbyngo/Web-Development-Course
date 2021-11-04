<html>
<head>
<title>Exercise 8-7</title>
</head>
<body>
<h1>Simple Calendar using Loops</h1>

<table border="1">


<tr>
  <th colspan="8"><?php echo $month = date('F');?></th>
<tr>
  <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
</tr>

<?php
  $dayOne = date("w",mktime(0,0,0,date("n"),1, date("Y")));
  while($day<=30){
    //when we need a new row go ahead.
    if($day%7==0){
      echo "</tr><tr>";
    }
    echo "<td>".($day+1)."</td>";
    $day++;
  }
?>

</table>


</body>
</html>
