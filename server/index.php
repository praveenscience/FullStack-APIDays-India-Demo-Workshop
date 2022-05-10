<?php
  $path = $_GET["path"];
  if ($path === "") {
    echo "Home";
  } else {
    echo $path;
  }
?>
