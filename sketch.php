<?php
include_once("listing.php");
$arr = [
  50, 24, "heii", 'a',
  [
    42, 47,
    [
      "Hello", "world", "key" => "value"
    ], 10
  ]
];
$li = new Listing($arr);
$li -> i4 -> i2 -> key = "new value";
print $li -> i4 -> i2 -> key;
// $li -> dump();
?>
