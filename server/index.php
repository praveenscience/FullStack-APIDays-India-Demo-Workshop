<?php
  ob_start();
  header("Content-type: application/json");
  $path = isset($_GET["path"]) && !empty($_GET["path"]) ? $_GET["path"] : "index";
  switch($path) {
    case "index":
      echo "Home";
      break;
    default:
      http_response_code(404);
      echo "Error 404";
      break;
  }
?>
