<?php

namespace App\Modules\Users\Controllers;

use App\Core\Controller;
use App\Modules\Users\Services\UserService;
use App\Services\PermissionService;

class UsersController extends Controller
{
    // ======================================================
    // INDEX
    // ======================================================
    public function index()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'view')) {
            return $this->redirect(BASE_URL);
        }

        $users = UserService::getAllForList($rolId);

        $permissions = PermissionService::getModulePermissions($rolId, 'users');

        $this->render('Modules/Users/Views/index', [
            'users' => $users,
            'canCreate' => $permissions['create']
        ]);
    }

    // ======================================================
    // CREATE (FORM)
    // ======================================================
    public function create()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'create')) {
            return $this->redirect(BASE_URL . "/users");
        }

        $roles = UserService::getRolesForCreate($rolId);

        $permissions = PermissionService::getModulePermissions($rolId, 'users');

        $this->render('Modules/Users/Views/create', [
            'roles' => $roles,
            'canCreate' => $permissions['create'],
            'currentRoleId' => $_SESSION['user']['rol_id'],
            'currentRoleName' => $_SESSION['user']['rol_nombre'],
        ]);
    }

    // ======================================================
    // STORE
    // ======================================================
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect(BASE_URL . "/users");
        }

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'create')) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/users");
        }

        try {
            UserService::create($_POST, $rolId);

            $_SESSION['success'] = "Usuario creado";
            return $this->redirect(BASE_URL . "/users");
        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage() ?: "Error al crear usuario";
            return $this->redirect(BASE_URL . "/users/create");
        }
    }

    // ======================================================
    // EDIT (FORM)
    // ======================================================
    public function edit()
    {
        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'edit')) {
            return $this->redirect(BASE_URL . "/users");
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return $this->redirect(BASE_URL . "/users");
        }

        try {
            $data = UserService::getForEdit($id, $rolId);

            $this->render('Modules/Users/Views/edit', $data);
        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage();
            return $this->redirect(BASE_URL . "/users");
        }
    }

    // ======================================================
    // UPDATE
    // ======================================================
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirect(BASE_URL . "/users");
        }

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'edit')) {
            $_SESSION['error'] = "No autorizado";
            return $this->redirect(BASE_URL . "/users");
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "ID inválido";
            return $this->redirect(BASE_URL . "/users");
        }

        try {
            UserService::update($_POST, $rolId);

            $_SESSION['success'] = "Usuario actualizado";
            return $this->redirect(BASE_URL . "/users");
        } catch (\Exception $e) {

            $_SESSION['error'] = $e->getMessage() ?: "Error al actualizar usuario";
            return $this->redirect(BASE_URL . "/users");
        }
    }

    // ======================================================
    // TOGGLE
    // ======================================================
    public function toggle()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'edit')) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            return print json_encode(['ok' => false, 'error' => 'ID inválido']);
        }

        try {
            $estado = UserService::toggle($id, $rolId);

            echo json_encode([
                'ok' => true,
                'estado' => $estado
            ]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // ======================================================
    // DELETE
    // ======================================================
    public function delete()
    {
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        if (!PermissionService::can($rolId, 'users', 'delete')) {
            return print json_encode(['ok' => false, 'error' => 'No autorizado']);
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            return print json_encode(['ok' => false, 'error' => 'ID inválido']);
        }

        try {
            UserService::delete($id, $rolId);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    // ======================================================
    // RESTORE
    // ======================================================
    public function restore()
    {
        var_dump($_FILES); exit;
        header('Content-Type: application/json');

        $rolId = $_SESSION['user']['rol_id'] ?? null;

        // 🔥 SOLO SUPER
        if ($rolId != \App\Core\Roles::SUPER) {
            return print json_encode([
                'ok' => false,
                'error' => 'No autorizado'
            ]);
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            return print json_encode([
                'ok' => false,
                'error' => 'ID inválido'
            ]);
        }

        try {
            \App\Modules\Users\Services\UserService::restore($id, $rolId);

            echo json_encode(['ok' => true]);
        } catch (\Exception $e) {

            echo json_encode([
                'ok' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
    // ======================================================
    // VERIFICAR DISPONIBILIDAD DE USERNAME
    // ======================================================

    public function checkUsername()
    {
        header('Content-Type: application/json');

          $username = $_POST['username'] ?? '';

        if (!$username) {
            echo json_encode(['exists' => false]);
            return;
        }

        $exists = \App\Modules\Users\Services\UserService::usernameExists($username);

        echo json_encode([
            'success' => true,
            'exists' => $exists
        ]);
    }
}
