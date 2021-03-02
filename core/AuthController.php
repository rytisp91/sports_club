<?php


namespace app\core;

use app\model\UserModel;

/**
 * Respossible for handling login and register.
 *
 * Class AuthController
 * @package app\core
 */
class AuthController extends Controller
{
    public Validation $vld;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->vld = new Validation();
        $this->userModel = new UserModel();
    }

    public function login(Request $request)
    {
        // have ability to change laout
        // $this->setLayout('auth');

        if ($request->isGet()) :
            $data = [
                'email' => '',
                'password' => '',
                'errors' => [
                    'emailErr' => '',
                    'passwordErr' => '',
                ]
            ];
            return $this->render('login', $data);
        endif;

        if ($request->isPost()) :
            // we get all post values sanitized
            $data = $request->getBody();

            // validation
            $data['errors']['emailErr'] = $this->vld->validateLoginEmail($data['email'], $this->userModel);

            $data['errors']['passwordErr'] = $this->vld->validateEmpty($data['password'], 'Please enter your password');

            // if there are no errors
            if ($this->vld->ifEmptyArr($data['errors'])) {
                // no errors
                // email was found and password was entered
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);


                if ($loggedInUser) {
                    // create session
                    // password match
                    // die('email and passs match start session immediately');
                    $this->createUserSession($loggedInUser);
                    $request->redirect('/posts');
                } else {
                    $data['errors']['passwordErr'] = 'Wrong password or email';
                    // load view with errors
                    return $this->render('login', $data);
                }
            }


            return $this->render('login', $data);
        endif;
    }

    public function register(Request $request)
    {
        if ($request->isGet()) :
            //            $this->setLayout('auth');

            // create data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'errors' => [
                    'nameErr' => '',
                    'emailErr' => '',
                    'passwordErr' => '',
                    'confirmPasswordErr' => '',
                ],
                'currentPage' => 'register',
            ];


            return $this->render('register', $data);
        endif;

        if ($request->isPost()) :

            // reques is post and we need to pull user data
            $data = $request->getBody();

            $data['errors']['nameErr'] = $this->vld->validateName($data['name']);

            $data['errors']['emailErr'] = $this->vld->validateEmail($data['email'], $this->userModel);

            $data['errors']['passwordErr'] = $this->vld->validatePassword($data['password'], 6, 10);

            $data['errors']['confirmPasswordErr'] = $this->vld->confirmPassword($data['confirmPassword']);

            // if there are no errors
            if ($this->vld->ifEmptyArr($data['errors'])) :


                // hash password // save way to store pass
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // create user
                if ($this->userModel->register($data)) {
                    // success user added
                    // set flash msg
                    //                    flash('register_success', 'You have registered successfully');
                    // header("Location: " . URLROOT . "/users/login");
                    $request->redirect('/login');
                } else {
                    die('Something went wrong in adding user to db');
                }

            endif;


            return $this->render('register', $data);
        endif;
    }


    /**
     *  if we have user we save its data in session
     * @param $userRow
     */
    public function createUserSession($userRow)
    {
        $_SESSION['user_id'] = $userRow->id;
        $_SESSION['user_email'] = $userRow->email;
        $_SESSION['user_name'] = $userRow->name;
    }

    public function logout(Request $request)
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();

        $request->redirect('/');
    }
}
