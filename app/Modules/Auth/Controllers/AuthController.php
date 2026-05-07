<?php
class AuthController {

    public function login() {

        $user = $_POST['user'];
        $pass = $_POST['pass'];

        $service = new AuthService();
        $result = $service->login($user, $pass);

        if($result['success']){
            header("Location: /dashboard");
        } else {
            $error = $result['message'];
            require "../Views/login.php";
        }
    }
}