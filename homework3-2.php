<?php
   /* Online PHP Compiler (Interpreter) and Editor */
$n = 30;
for ($x = 0; $x < $n; $x++) {
  $data[$x] = rand(10, 100);
}
sort($data);
foreach ($data as $value) {
    echo "$value<br>\n";
}
?>
