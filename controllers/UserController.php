<?php

use mvc\app\Controller;

class UserController extends Controller
{
     public function actionIndex()
     {
         if(isset($_SESSION['user'])) {
             if ($_SESSION['user']) {
                 header('Location: ' . Config::$conf['domain']);
             }
         }

         $this->render('signupView',[
             'message' => null,
         ]);
     }

    /**
     *
     */
     public function actionSignup()
     {
         /** signup logic is delegated to UserModel class*/
         $message = (new UserModel())->signUp($_POST);

         /** if something went wrong `$message` isn't empty */
         /** show to user the message about mistake */
         if($message){
             $this->render('signupView',[
                 'message' => $message,
             ]);
         }else{/** or, if everything ok -> allow user upload files */
             header('Location: ' . Config::$conf['domain'] . '/index.php?r=file/');
         }
     }

    /**
     *
     */
     public function actionLogin()
     {
         /** login logic is delegated to UserModel class*/
         $message = (new UserModel())->logIn($_POST);

         /** if something went wrong `$message` isn't empty */
         /** show to user the message about mistake */
         if($message) {
             $this->render('signupView', [
                 'message' => $message,
             ]);
         }else{/** or, if everything ok -> allow user upload files */
             header('Location: ' . Config::$conf['domain'] . '/index.php?r=file/');
         }
     }

    /**
     *
     */
    public function actionLogout()
    {
        /**
         * set session of user in
         * `false` & do redirect to Home page
         */
        (new UserModel())->logOut();
        header('Location: ' . Config::$conf['domain']);
    }

}


