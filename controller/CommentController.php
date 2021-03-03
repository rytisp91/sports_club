<?php

namespace app\controller;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\model\CommentModel;

class CommentController extends Controller
{
    protected CommentModel $commentModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
    }

    public function renderComments(Request $request)
    {
        if ($request->isGet()) :
            $comments = $this->commentModel->getComments();

            $data = [
                'comments' => $comments,
            ];

            return $this->render('comments', $data);
        endif;
    }


    public function getApiComments(Request $request)
    {
        if ($request->isPost()) :

            if ($_POST['commentBody'] !== '' && strlen($_POST['commentBody']) < 500) {
                if ($this->commentModel->addComment($_SESSION['user_name'], $_POST['commentBody'])) {
                    $comments = $this->commentModel->getComments();
                    $data = [
                        'success' => true,
                        'comments' => $comments,
                    ];
                }
            } else {
                if ($_POST['commentBody'] === '') {
                    $error = 'Please fill this field.';
                } else {
                    $error = 'Comment is too long. Maximum characters amount - 500.';
                }
                $data = [
                    'success' => false,
                    'error' => $error,
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($data);
        endif;
    }
}
