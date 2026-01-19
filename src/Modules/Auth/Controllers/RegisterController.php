<?php
namespace App\Modules\Auth\Controllers;

use App\Web\Controllers\BaseController;
use App\Modules\Auth\Services\AuthService;
use App\Core\Database\Connection;
use Exception;

class RegisterController extends BaseController {
    private $authService;

    public function __construct() {
        $database = Connection::getInstance();
        $this->authService = new AuthService($database->getConnection());
    }

    public function store() {
        return $this->index(); // Handle POST in index method
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = '';
        $success = '';
        $formData = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formData = [
                'username' => trim($_POST['username'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'full_name' => trim($_POST['full_name'] ?? ''),
                'university' => $_POST['university'] ?? '',
                'role' => $_POST['role'] ?? ''
            ];

            if ($_POST['password'] !== $_POST['confirm_password']) {
                $error = "Passwords do not match.";
            } elseif (strlen($_POST['password']) < 6) {
                $error = "Password must be at least 6 characters long.";
            } elseif (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Please enter a valid email address.";
            } elseif (empty($formData['username']) || empty($formData['full_name']) || empty($formData['university']) || empty($formData['role'])) {
                $error = "Please fill out all required fields.";
            } else {
                $result = $this->authService->register(
                    $formData['username'],
                    $formData['email'],
                    $_POST['password'],
                    $formData['full_name'],
                    $formData['university'],
                    $formData['role']
                );

                if ($result['success']) {
                    $success = 'Registration successful! You can now login.';
                    $formData = [];
                } else {
                    $error = $result['message'] ?? 'Registration failed. Username or email may already exist.';
                }
            }
        }

        $universities = [
            'University of the Philippines System' => [
                'University of the Philippines Diliman',
                'University of the Philippines Manila',
                'University of the Philippines Los Baños',
                'University of the Philippines Visayas',
                'University of the Philippines Mindanao',
                'University of the Philippines Open University',
                'University of the Philippines Baguio',
                'University of the Philippines Cebu'
            ],
            'Major State Universities' => [
                'Polytechnic University of the Philippines',
                'Technological University of the Philippines',
                'Philippine Normal University',
                'Mindanao State University',
                'Central Luzon State University',
                'Visayas State University',
                'Bicol University',
                'University of the Philippines in the Visayas'
            ],
            'Regional State Universities' => [
                'Bataan Peninsula State University',
                'Bulacan State University',
                'Cavite State University',
                'Laguna State Polytechnic University',
                'Nueva Ecija University of Science and Technology',
                'Pangasinan State University',
                'Tarlac State University',
                'Aurora State College of Technology',
                'Batangas State University',
                'Rizal Technological University'
            ],
            'Mindanao State Universities' => [
                'Mindanao State University - Main Campus',
                'Mindanao State University - Iligan Institute of Technology',
                'Mindanao State University - Tawi-Tawi',
                'Western Mindanao State University',
                'Southern Philippines Agribusiness and Marine and Aquatic School of Technology',
                'Surigao State College of Technology'
            ],
            'Visayas State Universities' => [
                'Visayas State University',
                'Central Philippines State University',
                'Negros Oriental State University',
                'Silliman University',
                'West Visayas State University',
                'Aklan State University',
                'Capiz State University'
            ]
        ];

        $this->renderWithoutLayout('auth/register', [
            'title' => 'Register - SUC Forum',
            'error' => $error,
            'success' => $success,
            'formData' => $formData,
            'universities' => $universities
        ]);
    }

    protected function renderWithoutLayout($view, $data = []) {
        extract($data);

        if (strpos($view, '/') !== false) {
            $parts = explode('/', $view, 2);
            $module = ucfirst($parts[0]);
            $viewFile = $parts[1];
            $viewPath = __DIR__ . "/../Views/{$viewFile}.php";
        } else {
            $viewPath = __DIR__ . "/../Views/{$view}.php";
        }

        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            throw new Exception("View not found: {$view}");
        }
    }
}
