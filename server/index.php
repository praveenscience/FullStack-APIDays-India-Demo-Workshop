<?php
  ob_start();
  $data = json_decode(file_get_contents("./data.json"), true);
  header("Content-type: application/json");
  $path = isset($_GET["path"]) && !empty($_GET["path"]) ? $_GET["path"] : "index";
  switch($path) {
    case "index":
      echo json_encode($data);
      break;
    default:
      http_response_code(404);
      echo "Error 404";
      break;
  }
?>
