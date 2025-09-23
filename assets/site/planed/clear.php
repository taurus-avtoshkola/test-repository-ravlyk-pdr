<?php

include('config.php');

$input = json_decode(file_get_contents("php://input"), true);

if ($input["planedId"] == NULL) {
    $result["state"] = false;
    $result["error"]["message"][] = "'planedId' is missing";
}
if ($result["state"] === false) {
    echo json_encode($result);
    exit;
}

$sql = "DELETE FROM `".$table."` WHERE `id` = '".$input["planedId"]."'";

$delete = mysqli_query($sqlConnect, $sql);

if ($delete == false) {
    $result["state"] = false;
    $result["error"]["message"][] = "failed delete string from sql";
    $result["error"]["sql"] = mysqli_error_list($sqlConnect);
} else {
    $result["state"] = true;
    $result["delete"]["count"] = mysqli_field_count($sqlConnect);
}

echo json_encode($result);