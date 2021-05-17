<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    session_start();
    include "/var/www/mitstudiekort.dk/html/api/onsite/db/conn.php";
    
    $username = mysqli_real_escape_string($conn, $_REQUEST['usr']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['pass']);
    $gymcode = mysqli_real_escape_string($conn, $_REQUEST['gc']);

    $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    $gymcode = htmlspecialchars($gymcode, ENT_QUOTES, 'UTF-8');

    $sqlOK = false;

    require 'simple_html_dom.php';

    $check = 0;

    

    function login($url, $data, $usr, $gymcode){
        file_put_contents('cookies/cookie_'.$usr.'.txt', "");
        $fp = fopen('cookies/cookie_'.$usr.'.txt', "w");
        //$fp = fopen("cookie.txt", "w");
        fclose($fp);
        $login = curl_init();
        curl_setopt($login, CURLOPT_COOKIEJAR, 'cookies/cookie_'.$usr.'.txt');
        curl_setopt($login, CURLOPT_COOKIEFILE, 'cookies/cookie_'.$usr.'.txt');
        curl_setopt($login, CURLOPT_TIMEOUT, 3600000);
        curl_setopt($login, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($login, CURLOPT_URL, $url);
        curl_setopt($login, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($login, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($login, CURLOPT_POST, TRUE);
        curl_setopt($login, CURLOPT_POSTFIELDS, $data);
        ob_start();
        return curl_exec ($login);
        ob_end_clean();
        curl_close ($login);
        unset($login);    
    }                  

    function grab_page($site,$usr,$gymcode){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/cookie_'.$usr.'.txt');
        curl_setopt($ch, CURLOPT_REFERER, "https://www.lectio.dk/lectio/".$gymcode."/forside.aspx?prevurl=login.aspx");
        curl_setopt($ch, CURLOPT_URL, $site);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        ob_start();
        return curl_exec($ch);
        ob_end_clean();

        curl_close ($ch);
    }

    function grab_image($url,$usr,$gymcode){
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies/cookie_'.$usr.'.txt');
        curl_setopt($ch, CURLOPT_REFERER, "https://www.lectio.dk/lectio/".$gymcode."/forside.aspx?prevurl=login.aspx");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
        $raw=curl_exec($ch);
        curl_close ($ch);
        if(file_exists('cardstore/users/'.$usr.'.png')){
            unlink('cardstore/users/'.$usr.'.png');
        }
        $fp = fopen('cardstore/users/'.$usr.'.png','x');
        fwrite($fp, $raw);
        fclose($fp);
    }

    login("https://www.lectio.dk/lectio/".$gymcode."/login.aspx", "time=0&__EVENTTARGET=m%24Content%24submitbtn2&__EVENTARGUMENT=&__SCROLLPOSITION=&__VIEWSTATEY_KEY=&__VIEWSTATE=&__EVENTVALIDATION=TfmbMXddgWgL6YwIxCpQHACyObb3hNNha5ZiIf1WW1QcSDjKyHyHeASP4QnJzSx3nEJ%2FKTasEjdfY38DcX3RRjadqNcvXaPK55OWJPVfGgGxSMgXaBe7tgej%2BJQDaYYyRrJcbabMqmNAc6IEj7Xkz895UHaD2df37BjqC2JOVh9ERV5EA2I3ND5%2FLXoF%2FOab3YtN0LBHaur5cEt3BAbA6uTlWqemvFuiVHprCdC7aCY%3D&m%24Content%24username=".$username."&m%24Content%24password=".$password."&masterfootervalue=X1%21%C3%86%C3%98%C3%85&LectioPostbackId=", $username, $gymcode);
    // sleep(1);

    $ls = grab_page("https://www.lectio.dk/lectio/".$gymcode."/forside.aspx", $username, $gymcode);
    $html = str_get_html($ls);

    $baseString = $html->find('#s_m_HeaderContent_MainTitle', 0);
    $baseString = $baseString->plaintext;

    if(strpos($baseString, "Læreren") !== false) {
        $isTeacher = 1;
    } else {
        $isTeacher = 0;
    }
    
    $studentName = $html->find('#s_m_HeaderContent_MainTitle', 0);
    $studentName = $studentName->plaintext;
    $studentName = substr($studentName, 7);
    $arr = explode(",", $studentName, 2);
    $studentName = $arr[0];

    $className = $html->find('#s_m_HeaderContent_MainTitle', 0);
    $className = $className->plaintext;
    $className = substr($className, strpos($className, ",") + 1);  
    $arr = explode("-", $className, 2);
    $className = $arr[0];  
    $className = substr($className, 0, -1);

    $schoolName = $html->find('#s_m_masterleftDiv', 0);
    $schoolName = $schoolName->plaintext;
    $schoolName = substr($schoolName, 4);
    $arr = explode("&nbsp", $schoolName, 2);
    $schoolName = $arr[0];

    $imageUrl = $html->find('img', 2)->src;

    $imageUrl = "https://www.lectio.dk".$imageUrl."&fullsize=1";

    $schoolName = rtrim($schoolName);
    $cardstoreref = "/dashboard/cardstore/users/".$username.".png";

    $ls = grab_page("https://www.lectio.dk/lectio/".$gymcode."/FindSkema.aspx?type=stamklasse", $username, $gymcode);
    $classeshtml = str_get_html($ls);

    $sql = "SELECT id FROM schools WHERE `name` = '".($schoolName)."'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 0) {
        $schoolName = mb_convert_encoding($schoolName, 'HTML-ENTITIES', 'utf-8');
        $sql2 = "INSERT INTO schools (name) VALUES ('$schoolName')";
        if ($conn->query($sql2)) { // INDSÆT NYT GYM NAVN
            $schoolId = $conn->insert_id;
            foreach($classeshtml->find(".x-listen p a") as $class) { // INDSÆT KLASSENAVNE
                $class = $class->plaintext;
                $class = mb_convert_encoding($class, 'HTML-ENTITIES', 'utf-8');
                $sql3 = "INSERT INTO classes (name, schoolId) VALUES ('$class', '$schoolId')";
                if ($conn->query($sql3)) {
                    $sqlOK = true;
                } else {
                    // ERROR
                    $sqlOK = false;
                }
            }
        } else {
            // ERROR!
        }
    } else if ($result->num_rows > 0) {
        // SCHOOL SEEN BEFORE - ALL GOOD
        $sqlOK = true;
    } else {
        // ERROR!
    }

    grab_image($imageUrl, $username, $gymcode); 

    if(strlen($studentName) > 0 && strlen($schoolName) > 0 && strlen($imageUrl) > 0 && strlen($gymcode) > 0 && strlen($className) > 0 && $sqlOK){
      $check = 1;
    }

    $resultArray = array($studentName, $schoolName, $cardstoreref, $gymcode, $check, $className, $isTeacher);
    $resultJSON = json_encode($resultArray, JSON_UNESCAPED_UNICODE);
    echo $resultJSON;
    $_SESSION['lectioData'] = $resultArray;
    unlink('cookies/cookie_'.$username.'.txt');
?>