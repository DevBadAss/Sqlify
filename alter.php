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
//http://localhost:3000/alter.php?api_key=dev&db=test.db&table=testing&new_column=testubes&datatype=text
    if(isset($_GET["new_column"]) && isset($_GET["datatype"])){
        $new_column = $_GET["new_column"];
        $datatype = $_GET["datatype"];

        $DB = new SQLite3($db);
        $DB->exec("ALTER TABLE $table ADD $new_column $datatype;");
        echo json_encode(array("result"=>"Success"));
    }
}



?>