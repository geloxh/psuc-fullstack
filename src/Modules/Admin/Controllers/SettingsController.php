<?php
namespace App\Modules\Admin\Controllers;

class SettingsController {
    public function index() {
        if (!$this->isAdmin()) {
            header('Location ../login.php');
        }
        include  __DIR__ . '/../Views/settings.php';
    }

    private function isAdmin() {
        $auth = new \Auth();
        return $auth->isAdmin();
    }
}