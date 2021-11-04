<?php
   // function definition can go here
?>
<html>
<head>
<title>Exercise 8-8</title>
</head>
<body>
<h1>Making and using functions</h1>


<table border=1>
<tr>
  <th>milliliters</th><th>Cups</th><th>Ounces</th>
<?php
for($i=50;$i<=1000;$i+=50){
   echo "<tr>";
   echo "<td>$i</td>";
   // replace the ??? with the calls to convertUnits function
   echo "<td>???</td>";
   echo "<td>???</td>";
   echo "</tr>";
}
?>
</tr>
</table>


</body>
</html>
