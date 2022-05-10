<?php
  $path = isset($_GET["path"]) && !empty($_GET["path"]) ? $_GET["path"] : "index";
  if ($path === "index") {
    echo "Home";
  } else {
    echo "Path: $path";
  }
?>
