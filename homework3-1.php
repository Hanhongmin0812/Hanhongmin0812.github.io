<!DOCTYPE html>
<html>
<body>

<?php
$n = 30;
$sum = 0;
$prod = 1;
for ($x = 1; $x < $n; $x++) {
    echo("$x + ");
  $sum = $x + $sum;
}
echo "$n = $sum<br>";
for ($x = 1; $x < $n; $x++) {
    echo("$x * ");
  $prod = $prod * $x;
}
echo "$x = $prod";
?>

</body>
</html>
