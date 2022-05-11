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
    case $path === "new":
      if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (isset($_POST["title"]) && !empty($_POST["title"]) && isset($_POST["body"]) && !empty($_POST["body"])) {
          $data[] = array(
            "title" => $_POST["title"],
            "body" => $_POST["body"],
            "timestamp" => time() * 1000,
            "comments" => array()
          );
          if (file_put_contents("./data.json", json_encode($data))) {
            http_response_code(201);
            echo json_encode("New post added.");
          } else {
            http_response_code(500);
            echo json_encode("Some error occurred.");
          }
        } else {
          http_response_code(500);
          echo json_encode("Both title and body are mandatory!");
        }
      } else {
        http_response_code(404);
        echo json_encode("Not Found!");
      }
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
          case "edit":
            if ($_SERVER['REQUEST_METHOD'] === "PUT") {
              $newData = json_decode(file_get_contents("php://input"), true);
              if (isset($newData["title"]) && !empty($newData["title"]) && isset($newData["body"]) && !empty($newData["body"])) {
                $data[intval($pathParts[0]) - 1]["title"] = $newData["title"];
                $data[intval($pathParts[0]) - 1]["body"] = $newData["body"];
                if (file_put_contents("./data.json", json_encode($data))) {
                  http_response_code(202);
                  echo json_encode("Post #{$pathParts[0]} updated.");
                } else {
                  http_response_code(500);
                  echo json_encode("Some error occurred.");
                }
              } else {
                http_response_code(500);
                echo json_encode("Both title and body are mandatory!");
              }
            } else {
              http_response_code(404);
              echo json_encode("Not Found!");
            }
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
