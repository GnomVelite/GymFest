<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

class User {
    public $token;
    public $service;
    public $response;

    public $data = [];

    function __construct($token, $service) {
        $this->token = $token;
        $this->service = $service;
    }

    /*function fetch_user() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://mitstudiekort.dk/api/offsite/auth/serviceFetch.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\"token\":\"f696b9dea99f4a800d2793f36e34b3f14b42b0ff\"}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $this->reponse = $response;
    }*/


    function fetch_user() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, "https://mitstudiekort.dk/api/offsite/auth/serviceFetch.php");
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"token":"'.$this->token.'"}');
        ob_start();
        $this->response = curl_exec($ch);
        $this->response = mb_convert_encoding($this->response, "UTF-8");
        $this->data = json_decode($this->response);
        ob_end_clean();
        curl_close($ch);
        unset($ch);

        $_SESSION["userdata"] = $this->data;
    }   


    function get_name() {
        return $this->user->expiry;
    }

    function dump_response() {
        return $this->response;
    }
}
?>