<?php

include('config.php');

$input = json_decode(file_get_contents("php://input"), true);

if ($input["userId"] == NULL) {
    $result["state"] = false;
    $result["error"]["message"][] = "'userId' is missing";
}
if ($input["timezone"] != NULL) {
    $setTimeZone = date_default_timezone_set($input["timezone"]);
    if ($setTimeZone === false) {
        $result["state"] = false;
        $result["error"]["message"][] = "'timezone' is invalid";
    }
}
if ($result["state"] === false) {
    echo json_encode($result);
    exit;
}

$sql = "SELECT * FROM `".$table."` WHERE `userId` = '".$input["userId"]."'";

$get = mysqli_query($sqlConnect, $sql);

if ($get == false) {
    $result["state"] = false;
    $result["error"]["message"][] = "failed delete string from sql";
    $result["error"]["sql"] = mysqli_error_list($sqlConnect);
} else {
    $result["state"] = true;
    $result["timezone"] = date_default_timezone_get();
    $result["count"] = mysqli_num_rows($get);
    $result["planed"] = mysqli_fetch_all($get, MYSQLI_ASSOC);
    foreach ($result["planed"] as &$onePlaned) {
        $onePlaned["date"] = date("d-m-Y H:i:s", $onePlaned["time"]);
    }
}

echo json_encode($result);