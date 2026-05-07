<?php
class AuthService {

    public function login($user, $pass) {

        // 1. Validaciones
        if(empty($user) || empty($pass)){
            return [
                "success" => false,
                "message" => "Campos vacíos"
            ];
        }

        // 2. Llamar al modelo
        $model = new UserModel();
        $usuario = $model->findByUsername($user);

        if(!$usuario){
            return [
                "success" => false,
                "message" => "Usuario no existe"
            ];
        }

        // 3. Validar contraseña
        if(!password_verify($pass, $usuario['password'])){
            return [
                "success" => false,
                "message" => "Contraseña incorrecta"
            ];
        }

        // 4. Crear sesión
        session_start();
        $_SESSION['user'] = $usuario['username'];

        return [
            "success" => true
        ];
    }
}