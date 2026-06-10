<?php

namespace App\Core;

use App\Core\Roles;
use App\Core\Status;

class Controller
{
    protected function render($view, $data = [], $layout = 'main')
    {
        $viewPath = __DIR__ . '/../' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: " . $view);
        }

        //  USER DATA
        $rolId = $_SESSION['user']['rol_id'] ?? null;


        //  GLOBAL DATA PARA TODAS LAS VISTAS
        $data['Status'] = Status::class;
        $data['rolId'] = $rolId;
        $data['rolNombre'] = $_SESSION['user']['rol_nombre'] ?? '';

        //  PERMISOS CENTRALIZADOS
        $data['canEdit'] = Roles::canEdit($rolId);
        $data['canDelete'] = Roles::canDelete($rolId);
        $data['canRestore'] = Roles::canRestore($rolId);

        //  TITLE AUTOMÁTICO
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

    //  USAR SOLO rol_id 
    protected function isAdmin()
    {
        return Roles::canEdit($_SESSION['user']['rol_id'] ?? null);
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

        $module = $parts[1] ?? '';
        $submodule = end($parts);

        $modulesMap = [
            'suppliers' => 'Proveedores',
            'products' => 'Productos',
            'users' => 'Usuarios',
            'dashboard' => 'Dashboard'
        ];

        $submodulesMap = [
            'colors' => 'Colores',
            'types' => 'Tipos de tela',
            'warehouses' => 'Bodegas'
        ];

        $actionsMap = [
            'index' => 'Listado',
            'create' => 'Crear',
            'edit' => 'Editar'
        ];

        $moduleName = $modulesMap[$module] ?? ucfirst($module);

        // SI ES SUBMÓDULO
        if (isset($submodulesMap[$submodule])) {
            return $submodulesMap[$submodule];
        }

        // SI ES ACCIÓN NORMAL
        $actionName = $actionsMap[$submodule] ?? ucfirst($submodule);

        if ($submodule === 'index') {
            return $moduleName;
        }

        return "$actionName $moduleName";
    }
}
