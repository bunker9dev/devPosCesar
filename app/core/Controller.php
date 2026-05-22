<?php

namespace App\Core;

define('ROL_SUPER', 1);
define('ROL_ADMIN', 2);

class Controller
{


    protected function render($view, $data = [], $layout = 'main')
    {
        $viewPath = __DIR__ . '/../' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: " . $view);
        }

        // 🔥 PERMISOS
        $data['rol'] = $_SESSION['user']['rol_nombre'] ?? '';

        $data['canEdit'] = in_array($data['rol'], ['super', 'administrador', 'secretaria']);
        $data['canDelete'] = in_array($data['rol'], ['super', 'administrador']);
        $data['canRestore'] = ($data['rol'] === 'super');

        // 🔥 TITLE AUTOMÁTICO
        if (!isset($data['title'])) {
            $data['title'] = $this->generateTitle($view);
        }

        extract($data);

        $content = $viewPath;

        require __DIR__ . "/../Views/layouts/{$layout}.php";
    }


    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    protected function auth()
    {
        if (empty($_SESSION['user'])) {
            $this->redirect(BASE_URL . "/login");
        }
    }

    protected function isAdmin()
    {

        return in_array($_SESSION['user']['rol'] ?? null, [ROL_SUPER, ROL_ADMIN]);
    }

    protected function onlyAdmin()
    {
        if (!$this->isAdmin()) {
            $this->redirect(BASE_URL . "/dashboard");
        }
    }

    protected function generateTitle($view)
    {
        $parts = explode('/', strtolower($view));

        // Modules/Suppliers/Views/index
        $module = $parts[1] ?? ''; // Suppliers
        $action = end($parts);     // index

        $modulesMap = [
            'suppliers' => 'Proveedores',
            'products' => 'Productos',
            'users' => 'Usuarios',
            'dashboard' => 'Dashboard'
        ];

        $actionsMap = [
            'index' => 'Listado',
            'create' => 'Crear',
            'edit' => 'Editar'
        ];

        $moduleName = $modulesMap[$module] ?? ucfirst($module);
        $actionName = $actionsMap[$action] ?? ucfirst($action);

        // 🔥 RESULTADO PRO
        if ($action === 'index') {
            return $moduleName;
        }

        return "$actionName $moduleName";
    }
}
