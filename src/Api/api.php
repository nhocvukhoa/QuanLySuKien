<?php 
    //include_once("./connect.php");
    // if(isset($_SERVER['HTTP_ORIGIN'])){
    //     header('Access-Control-Allow-Origin: *');
    //     header('Access-Control-Allow-Credentials: true');
    //     header('Access-Control-Max-Age: 1000');
    // }
    // if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    //     if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])){
    //         header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    //     }

    //     if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])){
    //         header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding,
    //          X-CSRF-Token, Authorization");
    //     }
    //     exit(0);
    // }
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

        exit(0);
    }
?>