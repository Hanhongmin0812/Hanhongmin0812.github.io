<!DOCTYPE html>
<html>
<body>

<?php
$n = intval($_GET["userinput"]);
for ($x = 0; $x < $n; $x++) {
  $data[$x] = rand(10, 100);
}
sort($data);
foreach ($data as $value) {
    echo "$value<br>\n";
}
?>

</body>
</html>
