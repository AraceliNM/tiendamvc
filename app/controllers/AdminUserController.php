<?php

class AdminUserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('AdminUser');
    }

    public function index()
    {
        $session = new Session();

        if ($session->getLogin()) {
            $data = [
                'titulo' => 'Administración de Usuarios',
                'menu' => false,
                'admin' => true,
                'data' => [],
            ];

            $this->view('admin/users/index', $data);
        } else {
            header('LOCATION:' . ROOT . 'admin');
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $errors = [];

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password1 = $_POST['password1'] ?? '';
            $password2 = $_POST['password2'] ?? '';

            $dataForm = [
                'name' => $name,
                'email' => $email,
                'password' => $password1,
            ];

            if (empty($name)) {
                array_push($errors, 'El nombre de usuario es requerido');
            }
            if (empty($email)) {
                array_push($errors, 'El correo electrónico de usuario es requerido');
            }
            if (empty($password1)) {
                array_push($errors, 'La clave de acceso es requerida');
            }
            if (empty($password2)) {
                array_push($errors, 'La verificación de clave es requerida');
            }
            if ($password1 != $password2) {
                array_push($errors, 'Las claves no coinciden');
            }

            if ( ! $errors) {

                if ($this->model->createAdminUser($dataForm)) {
                    header('location:' . ROOT . 'adminUser');
                } else {

                    $data = [
                        'titulo' => 'Error en la creación de un usuario de administrador',
                        'menu' => false,
                        'errors' => [],
                        'subtitle' => 'Error al crear un nuevo usuario administrador',
                        'text' => 'Se ha producido un error durante el proceso de creación de un usuario administrador',
                        'color' => 'alert-danger',
                        'url' => 'adminUser',
                        'colorButton' => 'btn-danger',
                        'textButton' => 'Volver',
                    ];

                    $this->view('mensaje', $data);
                }

            } else {

                $data = [
                    'titulo' => 'Administración de Usuarios - Alta',
                    'menu' => false,
                    'admin' => true,
                    'errors' => $errors,
                    'data' => $dataForm,
                ];

                $this->view('admin/users/create', $data);

            }

        } else {

            $data = [
                'titulo' => 'Administración de Usuarios - Alta',
                'menu' => false,
                'admin' => true,
                'data' => [],
            ];

            $this->view('admin/users/create', $data);
        }
    }

    public function update()
    {
        print 'Modificación de usuarios';
    }

    public function delete()
    {
        print 'Eliminación de usuarios';
    }
}