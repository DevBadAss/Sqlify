<?php


include "key.php";

if (isset($_GET["api_key"])) {
    $KEY = $_GET["api_key"];
    if ($KEY !== getenv("API_KEY")) {
        echo json_encode(array("error" => "Wrong api key!"));
        die();
    }
} else {
    echo json_encode(array("error" => "No api key found!"));
    die();
}


if (isset($_GET["db"]) && isset($_GET["table"])) {
    $db = $_GET["db"];
    $table = $_GET["table"];

    //http://localhost:3000/update.php?api_key=dev&db=test.db&table=testing&set_column=pass&set_value=Doe&where=true&key=username&value=John%20Doe
    if (isset($_GET["where"])) {
        $where = $_GET["where"];
        if ($where === "true") {
            if (isset($_GET["set_column"]) && isset($_GET["set_value"]) && isset($_GET["key"]) && isset($_GET["value"])) {
                $set_column = $_GET["set_column"];
                $set_value = $_GET["set_value"];
                $query_key = $_GET["key"];
                $query_value = $_GET["value"];
                $DB = new SQLite3($db);
                $DB->exec("UPDATE $table SET $set_column='$set_value' WHERE  $query_key='$query_value';");
                echo json_encode(array("result" => "Success"));
            }
        }
    } else {
    //http://localhost:3000/update.php?api_key=dev&db=test.db&table=testing&set_column=pass&set_value=Doe
            if (isset($_GET["set_column"]) && isset($_GET["set_value"])) {
                $set_column = $_GET["set_column"];
                $set_value = $_GET["set_value"];
                $DB = new SQLite3($db);
                $DB->exec("UPDATE $table SET $set_column='$set_value';");
                echo json_encode(array("result" => "Success"));
            }
    }
}

?>