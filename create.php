<?php

include "key.php";

if (isset($_GET["api_key"]) && isset($_GET["action"])) {
    $KEY = $_GET["api_key"];
    $ACTION = $_GET["action"];

    if($KEY !== getenv("API_KEY")){
        echo json_encode(array("error"=>"Wrong api key!"));
        die();
    }
}else{
    echo json_encode(array("error"=>"No api key found!"));
    die();
}


//http://localhost:3000/create.php?api_key=dev&action=db&name=test.db
if($ACTION === "DB" || $ACTION === "db"){
    if(isset($_GET["name"])){
        $name = $_GET["name"];
    }
    $newDB = new SQLite3($name);
    echo json_encode(array("result"=>"Success", "filepath"=>realpath($name)));
}

//http://localhost:3000/create.php?api_key=dev&action=table&name=testing&schema=username text, pass, text&db=test.db
if($ACTION === "table"){
    if(isset($_GET["name"]) && isset($_GET["schema"]) && isset($_GET["db"])){
        $name = $_GET["name"];
        $db = $_GET["db"];
        $schema = rawurldecode($_GET["schema"]);
    }
    $DB = new SQLite3($db);
    $DB->exec("CREATE TABLE $name($schema);");
    echo json_encode(array("result"=>"Success"));
}
?>