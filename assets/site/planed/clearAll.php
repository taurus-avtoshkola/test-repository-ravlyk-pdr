<?php

include('config.php');

$input = json_decode(file_get_contents("php://input"), true);

if ($input["userId"] == NULL) {
    $result["state"] = false;
    $result["error"]["message"][] = "'userId' is missing";
}
if ($result["state"] === false) {
    echo json_encode($result);
    exit;
}

$sql = "DELETE FROM `".$table."` WHERE `userId` = '".$input["userId"]."'";

$delete = mysqli_query($sqlConnect, $sql);

if ($delete == false) {
    $result["state"] = false;
    $result["error"]["message"][] = "failed delete string from sql";
    $result["error"]["sql"] = mysqli_error_list($sqlConnect);
} else {
    $result["state"] = true;
    $result["delete"]["count"] = mysqli_affected_rows($sqlConnect);
}

echo json_encode($result);