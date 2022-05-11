<?php
  ob_start();
  $data = json_decode(file_get_contents("./data.json"), true);
  header("Content-type: application/json");
  $path = isset($_GET["path"]) && !empty($_GET["path"]) ? $_GET["path"] : "index";
  echo $path;
  switch(true) {
    case $path === "index":
      echo json_encode($data);
      break;
    case is_numeric($path):
      echo "Number Given";
      break;
    case $path === "time":
      echo json_encode(time() * 1000);
      break;
    default:
      http_response_code(404);
      echo "Error 404";
      break;
  }
?>
