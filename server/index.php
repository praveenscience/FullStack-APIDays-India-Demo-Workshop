<?php
  ob_start();
  $data = json_decode(file_get_contents("./data.json"), true);
  header("Content-type: application/json");
  $path = isset($_GET["path"]) && !empty($_GET["path"]) ? $_GET["path"] : "index";
  $pathParts = explode("/", $path);
  switch(true) {
    case $path === "index":
      echo json_encode($data);
      break;
    case is_numeric($path):
    case is_numeric($pathParts[0]) && $pathParts[1] === "":
      if (isset($data[intval($pathParts[0]) - 1])) {
        echo json_encode($data[intval($pathParts[0]) - 1]);
      } else {
        http_response_code(404);
        echo json_encode("Not Found!");
      }
      break;
    case is_numeric($pathParts[0]):
      if (isset($data[intval($pathParts[0]) - 1])) {
        switch ($pathParts[1]) {
          case "comments":
            echo json_encode($data[intval($pathParts[0]) - 1]["comments"]);
            break;
          default:
            http_response_code(404);
            echo "Unknown action!";
            break;
        }
      } else {
        http_response_code(404);
        echo json_encode("Not Found!");
      }
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
