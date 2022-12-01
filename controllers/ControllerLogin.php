<?php

    class ControllerLogin {

        public function index() {
            require 'views/viewLogin.php';
        }

        public function verify() {

            require 'models/modelLogin.php';
            require 'models/modelNewAccount.php';

            unset($_SESSION['login_error']);

            if (isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {

                /* Sécurité supplémentaire */
                $email = htmlspecialchars($_POST['email']);
                $pwd   = htmlspecialchars($_POST['password']);

                $modelLogin = new modelLogin();
                $user  = $modelLogin->get_user($email, $pwd);

            if ( $user && $pwd == $_POST['password'] ) {

                $modelNewAccount = new modelNewAccount();
                $_SESSION['id'] = $modelNewAccount->get_id_by_username($username);

                if( $modelNewAccount->get_verified($_SESSION['id']) === 1 ) {
                    $_SESSION['verified'] = 1;
                    $_SESSION['mail'] = $email;
                    $_SESSION['pwd'] = $pwd;

                    header('Location: ../home');
                }

            } else {
                $_SESSION['login_error'] = "Mauvais email ou mot de passe";
                header('Location: ../login');
            }

        }

    }
    
}

?>