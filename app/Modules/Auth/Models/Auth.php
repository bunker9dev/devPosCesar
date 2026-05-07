<?php
class UserModel {

    public function findByUsername($user) {
        // consulta real
        return [
            "username" => "admin",
            "password" => password_hash("1234", PASSWORD_DEFAULT)
        ];
    }
}