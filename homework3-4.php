<!DOCTYPE html>
<html>
<body>

<?php
$width1 =$_GET["width1"];
$width2 =$_GET["width2"];
$width3 =$_GET["width3"];
$radius1 =$_GET["radius1"];
$radius2 =$_GET["radius2"];
$radius3 =$_GET["radius3"];
$height1 =$_GET["height1"];
$height2 =$_GET["height2"];
$height3 =$_GET["height3"];
$height4 =$_GET["height4"];
$length = $_GET["length"];

echo "width1*height1/2 = ",$width1*$height1/2,"<br>\n";
echo "width2*height2/2 = ",$width2*$height2,"<br>\n";
echo "pi*radius^2 = ",pi() * ($radius1**2),"<br>\n";
echo "width3*height3*length = ",$width3*$height3*$length,"<br>\n";
echo "pi*radius^2*height = ",pi() * ($radius2**2) * $height4,"<br>\n";
echo "4/3*pi*radius^3* = ",pi() * 4/3 * ($radius3**3),"<br>\n";
?>
</body>
</html>
