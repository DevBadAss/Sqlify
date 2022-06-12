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

if(isset($_GET["table"]) && isset($_GET["db"])){
    $table = $_GET["table"];
    $db = $_GET["db"];


    //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&columns=pass
    if(isset($_GET["columns"])){
        $columns = $_GET["columns"];

    //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&columns=pass&limit=2
        if(isset($_GET["limit"])){
            $limit = $_GET["limit"];
            $DB = new SQLite3($db);
            $stmt = $DB->query("SELECT $columns FROM $table LIMIT $limit;");

            while ($result = $stmt->fetchArray(SQLITE3_ASSOC)) {
                if ($result !== false) {
                    $RESULT[] = $result;
                }
                if ($result === false) {
                    $RESULT = null;
                }
            }
            echo json_encode(array("data" => $RESULT));
        }else{
            $DB = new SQLite3($db);
            $stmt = $DB->query("SELECT $columns FROM $table;");

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

    //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing
    if(!isset($_GET["columns"]) && !isset($_GET["where"]) && !isset($_GET["order"])){
        //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&limit=2
        if(isset($_GET["limit"])){
            $limit = $_GET["limit"];
            $DB = new SQLite3($db);
            $stmt = $DB->query("SELECT * FROM $table LIMIT $limit;");

            while ($result = $stmt->fetchArray(SQLITE3_ASSOC)) {
                if ($result !== false) {
                    $RESULT[] = $result;
                }
                if ($result === false) {
                    $RESULT = null;
                }
            }
            echo json_encode(array("data" => $RESULT));
        }else{
            $DB = new SQLite3($db);
            $stmt = $DB->query("SELECT * FROM $table;");

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

    //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&where=true&key=username&value=emma
    if(isset($_GET["where"])){
        $where = $_GET["where"];
        if($where === "true"){
            if(isset($_GET["key"]) && isset($_GET["value"])){
                $query_key = $_GET["key"];
                $query_value = $_GET["value"];

                //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&where=true&key=username&value=emma&limit=1
                if(isset($_GET["limit"])){
                    $limit = $_GET["limit"];
                    $DB = new SQLite3($db);
                    $stmt = $DB->query("SELECT * FROM $table WHERE $query_key='$query_value' LIMIT $limit;");

                    while ($result = $stmt->fetchArray(SQLITE3_ASSOC)) {
                        if ($result !== false) {
                            $RESULT[] = $result;
                        }
                        if ($result === false) {
                            $RESULT = null;
                        }
                    }
                    echo json_encode(array("data" => $RESULT));
                }else{
                    $DB = new SQLite3($db);
                    $stmt = $DB->query("SELECT * FROM $table WHERE $query_key='$query_value';");

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
    }

    //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&order=true&column=username,pass&order_columns=username%20ASC,pass%20DESC
    if(isset($_GET["order"])){
        $orderby = $_GET["order"];
        if($orderby === "true"){
            if(isset($_GET["column"]) && isset($_GET["order_columns"])){
                $column = $_GET["column"];
                $order_columns = $_GET["order_columns"];

                //http://localhost:3000/query.php?api_key=dev&db=test.db&table=testing&order=true&column=username,pass&order_columns=username%20ASC,pass%20DESC&limit=2
                if(isset($_GET["limit"])){
                    $limit = $_GET["limit"];
                    $DB = new SQLite3($db);
                    $stmt = $DB->query("SELECT $column FROM $table ORDER BY $order_columns LIMIT $limit;");

                    while ($result = $stmt->fetchArray(SQLITE3_ASSOC)) {
                        if ($result !== false) {
                            $RESULT[] = $result;
                        }
                        if ($result === false) {
                            $RESULT = null;
                        }
                    }
                    echo json_encode(array("data" => $RESULT));
                }else{
                    $DB = new SQLite3($db);
                    $stmt = $DB->query("SELECT $column FROM $table ORDER BY $order_columns;");

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
    }

}
?>