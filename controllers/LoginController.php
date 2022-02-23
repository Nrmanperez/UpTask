<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {

    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if(empty($alertas)) {

                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);

                if(!$usuario || $usuario->confirmado === "0") {
                    Usuario::setAlerta('error', 'El Usuario No Existe o no esta Confirmado');
                } else {
                    // Usuario existe
                    if(password_verify($_POST['password'], $usuario->password)) {

                        // Iniciar la sesion
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        // Redireccionar
                        header('Location: /dashboard');

                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto');
                    }
                }
            }

            $alertas = Usuario::getAlertas();
        }

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas
        ]);
    }

    public static function logout() {
        
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function crear(Router $router) {

        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas= $usuario->validarNuevaCuenta();

            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);
            
                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {

                    // Hashear el Password
                    $usuario->hashPassword();

                    // Eliminar Password2
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();

                    // Crear un nuevo Usuario
                    $resultado = $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    
                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                // Buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado === "1") {

                    // Generar un nuevo Token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $resultado = $usuario->guardar();

                    // Enviar el Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarReestablecer();

                    // Imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu Email');

                } else {
                
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Recupera tu Password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router) {

        $token = s($_GET['token']);
        $mostrar = TRUE;

        if(!$token) {
            header('Location: /');
        }

        // Identificar el usuario con este Token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Valido');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Añadir el nuevo Password
            $usuario->sincronizar($_POST);

            // Validar el Password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {

                // Hashear el nuevo Password
                $usuario->hashPassword();

                // Eliminar el Token
                $usuario->token = null;

                // Guardar el usuario en la BD
                $resultado = $usuario->guardar();

                // Redireccionar
                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablece tu cuenta',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router) {

        // Render a la vista
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada exitosamente'
        ]);

    }

    public static function confirmar(Router $router) {

        $token = $_GET['token'];

        if(!$token) {
            header('Location: /');
        }

        // Encontrar al usuario con este Token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {

            // No se encontro un usuario con ese Token
            Usuario::setAlerta('error', 'Token no valido');

        } else {
            // Confirmar la cuenta
            $usuario->confirmado = 1;
            unset($usuario->password2);
            $usuario->token = null;
            

            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);

    }
}