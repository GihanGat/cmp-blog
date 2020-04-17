<?php

class BloggerLog extends Controller{

    function __construct(){
        parent::__construct();
    }

    function Index(){
        $is_auth = isset($_SESSION["username"]);
        //$this->testLogin();
        $this->Login();
    }

    function testLogin(){
        $this->model("BloggerModel");
        $auth = $this->BloggerModel->authenticateBlogger('gihanmadurangasl@gmail.com','password');
        if($auth){
            echo("Authenticated");
        }else{
            echo("Not Authenticated");
        }
    }

    function Logout(){
        session_unset();
        session_destroy();
        $_SESSION = Array();

        header("location: /main/logout");
    }
 
    function Login() {
        if ($_SERVER["REQUEST_METHOD"] == "GET"){
            $csrfToken = bin2hex(random_bytes(32));
            $_SESSION['csrfToken'] = $csrfToken;
            setcookie("csrfToken", $csrfToken);
            $this->view("main/login", array("csrfToken" => $csrfToken));

        }elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $post_csrf = htmlentities($_POST["csrfToken"]);
            $cook_csrf = htmlentities($_COOKIE["csrfToken"]);
            $session_csrf = $_SESSION["csrfToken"];

            if ($session_csrf == $post_csrf && $session_csrf == $cook_csrf) {
                $this->model("BloggerModel");
                $cl_name = htmlentities($_POST["loginname"]);
                $cl_passwd = htmlentities($_POST["password"]);

                $auth = $this->BloggerModel->authenticateUser($cl_name, $cl_pass);
                if ($auth) {
                    header("location: /main/home");
                } else {
                    echo("Not Authenticated");
                }
            } else {
                echo("bad csrf");
            }
        } else { 
               //header($_SERVER["SERVER_PROTOCOL"]. "405 Method Not Allowed", true,405);
               http_response_code(405);
               exit;
        }
    }


    function authenticateUser($username, $password) {
        $cl_name = $username;
        $cl_pass = $password;

        $sql = "SELECT `first_name`, `last_name`, `password_hash` FROM `authors` WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $count = $stmt->execute(Array($cl_name));
        $row = $stmt->fetch();
        $pass_hash = $row[2];
        $is_auth = false;
        if (isset($pass_hash)) {
            $is_auth = password_verify($cl_pass, $pass_hash);
            if ($is_auth) {
                
                $_SESSION['firstname'] = $row[0];
                $_SESSION['lastname'] = $row[1];
                $_SESSION['loginname'] = $cl_name;

                $upd_sql = "UPDATE `authors` SET `last_login` = CURRENT_TIMESTAMP() WHERE `email` = ?";
                $upd_stmt = $this->db->prepare($upd_sql);
                $upd_stmt->execute(Array($cl_name));
            }
        }

        return $is_auth;
    }
}   
?>