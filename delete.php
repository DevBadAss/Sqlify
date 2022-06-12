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

if(isset($_GET["db"]) && isset($_GET["table"])){
    $table = $_GET["table"];
    $db = $_GET["db"];

//http://localhost:3000/delete.php?api_key=dev&db=test.db&table=testing&where=true&key=pass&value=judah
    if(isset($_GET["where"])){
        $where = $_GET["where"];
        if($where === "true"){
            if(isset($_GET["key"]) && isset($_GET["value"])){
                $query_key = $_GET["key"];
                $query_value = $_GET["value"];

                $DB = new SQLite3($db);
                $DB->exec("DELETE FROM $table WHERE $query_key='$query_value';");
                echo json_encode(array("result"=>"Success"));
            }
        }
    }else{
//http://localhost:3000/delete.php?api_key=dev&db=test.db&table=testing

        $DB = new SQLite3($db);
        $DB->exec("DELETE FROM $table;");
        echo json_encode(array("result"=>"Success"));
    }
}


?>