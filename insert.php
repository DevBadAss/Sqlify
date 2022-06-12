<?php

include "key.php";

if (isset($_GET["api_key"])) {
    $KEY = $_GET["api_key"];
    if($KEY !== getenv("API_KEY")){
        echo json_encode(array("error"=>"Wrong api key!"));
        die();
    }
}else{
    echo json_encode(array("error"=>"No api key found!"));
    die();
}


if (isset($_GET["table"]) && isset($_GET["db"]) && isset($_GET["values"])) {
    $table = $_GET["table"];
    $db = $_GET["db"];
    $values = $_GET["values"];


    //http://localhost:3000/insert.php?api_key=dev&db=test.db&table=testing&values='emmiz'&columns=username
    if (isset($_GET["columns"])) {
        $columns = $_GET["columns"];
        $DB = new SQLite3($db);
        $DB->exec("INSERT INTO $table($columns) VALUES(".$values.");");
        echo json_encode(array("result"=>"Success"));
    } else {
        //http://localhost:3000/insert.php?api_key=dev&db=test.db&table=testing&values='emma','tests'
        $DB = new SQLite3($db);
        $DB->exec("INSERT INTO $table VALUES(".$values.");");
        echo json_encode(array("result"=>"Success"));
    }
}


?>