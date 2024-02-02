<?php
header ('content-type: application/json');
$request = $_SERVER['REQUEST_METHOD'];
switch ($request) {
  case 'GET':
  getmethod();
    break;

    case 'PUT':

      $data = json_decode(file_get_contents('php://input'),true);
      putmethod($data);

      break;


  case 'POST':
  $data = json_decode(file_get_contents('php://input'),true);
    postmethod($data);
  break;

  case 'DELETE':
  $data = json_decode(file_get_contents('php://input'),true);
    deletemethod($data);
  break;

  default:
    echo '{"name" : "Data Not Found"}';
    break;

}

// *********Get*********Data Get Part

function getmethod(){
  include "db.php";
  $sql = "SELECT * FROM dbname";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) >0) {
    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
    $rows["result"][] = $r;
    }
    echo json_encode($rows);
  }else {
    echo '{"result" : " No Data Found"}';
  }

}

// ************post***Data Insert Part

function postmethod($data){
  include "db.php";
  $name = $data['name'];
    $email = $data['email'];

  $sql = "INSERT INTO dbname(name,email,created_at) VALUES('$name', '$email', NOW()) ";
  if (mysqli_query($conn, $sql)){
  echo '{"result" : "Data Inserted"}';
}else {
  echo '{"result" : "Data Not Inserted "}';
}

}
// **********PUT*** Data Edit Part


function putmethod($data){
  include "db.php";
  $id = $data["id"];
  $name = $data["name"];
    $email = $data["email"];

  $sql = "UPDATE dbname SET name = '$name', email = '$email', created_at = NOW() WHERE id = '$id'";
  if (mysqli_query($conn, $sql)){
  echo '{"result" : "Update Successfully"}';
}else {
  echo '{"result" : "Data Not Update "}';
}

}

// *******************Delete**Delete Data

function deletemethod($data){
  include "db.php";
  $id = $data["id"];


  $sql = "DELETE FROM dbname WHERE id=$id";
  if (mysqli_query($conn, $sql)){
  echo '{"result" : "Delete Successfully"}';
}else {
  echo '{"result" : " Not Deleted "}';
}

}





 ?>
