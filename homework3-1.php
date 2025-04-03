<!DOCTYPE html>
<html>
<body>

<?php
$n = $_GET["userinput"];
$sum = 0;
$prod = 1;
for ($x = 1; $x < $n+1; $x++) {
  $sum = $x + $sum;
  $prod = $prod * $x;
}
echo "1부터 30까지의 합은 = $sum<br>";
echo "1부터 30까지의 곱은 = $prod";
?>

</body>
</html>
