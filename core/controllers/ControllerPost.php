<?php


namespace controllers;


use base\Controller;
use library\Auth;
use library\HttpException;
use library\Request;
use library\Url;
use models\Category;
use models\Post;

class ControllerPost extends Controller
{

    public function actionIndex()
    {
        header('Location: /');
    }

    public function actionView()
    {
        //todo: изменить вместе с UrlRules!
        $postId = Url::getSegment(2);
        if (empty($postId) or !(is_numeric($postId))) {
            throw new HttpException('Not Found', 404);
        }
        //---------------------------------
        $model = new Post($postId);
        $this->_view->setTitle($model->title);
        $this->_view->setLayout('main');
        $this->_view->render('post_view', ['model' => $model]);

    }

    public function actionCreate(){
        if (!Auth::isGuest()) {
            $model = new Post();
            if (Request::isPost()) {
                //load the data into the model and check it
                if ($model->load(Request::getPost()) and $model->validate()) {
                    if ($model->create()) {
                        header('Location: /post/view/' . $model->id);
                    }
                }
            }
            $this->_view->setTitle('Создание поста');
            $categories = Category::getAllCategories();
            $this->_view->render('post_form', ['model' => $model, 'categories' => $categories]);
        } else {
            header('Location: /main/login/');
        }
    }

    public function actionEdit(){
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $postId = Url::getSegment(2);
            //---------------------------------
            if (empty($postId) or !(is_numeric($postId))) {
                return false;
            }
            $model = new Post($postId);
            if (($model->author['id'] == Auth::getId()) or (Auth::getRole() == 'admin')) {
                if (Request::isPost()) {
                    //load the data into the model and check it
                    if ($model->load(Request::getPost()) and $model->validate()) {
                        if ($model->update()) {
                            header('Location: /post/view/' . $model->id);
                        }
                    }
                }
                $this->_view->setTitle($model->title);
                $categories = Category::getAllCategories();
                $this->_view->render('post_form', ['model' => $model, 'categories' => $categories]);
            } else {
                throw new HttpException('Forbidden', 403);
            }
        } else {
            header('Location: /main/login/');
        }
    }

    public function actionDelete(){
        if (!Auth::isGuest()) {
            //todo: изменить вместе с UrlRules!
            $postId= Url::getSegment(2);
            //---------------------------------
            if (empty($postId) or !(is_numeric($postId))) {
                return false;
            }
            $model = new Post($postId);
            if (($model->author['id'] == Auth::getId()) or (Auth::getRole() == 'admin')) {
                if($model->delete()){
                    header('Location: /');
                }
            }
        }
    }
}