<?php

use mvc\app\Controller;

class HomeController extends Controller
{
    public function actionIndex()
    {
        $this->render('indexView');
    }

}