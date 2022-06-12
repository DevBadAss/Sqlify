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

if(isset($_GET["db"]) && isset($_GET["table"])){
    $table = $_GET["table"];
    $db = $_GET["db"];
//http://localhost:3000/table.php?api_key=dev&db=test.db&table=tests&type=drop
    if(isset($_GET["type"])){
        $type = $_GET["type"];

        if($type === "drop"){
            $DB = new SQLite3($db);
            $DB->exec("DROP TABLE $table;");
            echo json_encode(array("result"=>"Success"));
        }

//http://localhost:3000/table.php?api_key=dev&db=test.db&table=tests&type=tables
        if($type === "tables"){
            $DB = new SQLite3($db);
            $stmt = $DB->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name;");

            while ($result = $stmt->fetchArray(SQLITE3_ASSOC)) {
                if ($result !== false) {
                    $RESULT[] = $result;
                }
                if ($result === false) {
                    $RESULT = null;
                }
            }
            echo json_encode(array("data" => $RESULT));
        }
    }
}

?>