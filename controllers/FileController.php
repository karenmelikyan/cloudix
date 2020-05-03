<?php

use mvc\app\Controller;

class FileController extends Controller
{
    public function actionindex()
    {
        if($_SESSION['user']) {
            $this->render('uploadView', [
                'message' => null,
            ]);
        }else{
            header('Location: ' . Config::$conf['domain'] . '/index.php?r=user/');
        }
    }

    /**
     *
     */
    public function actionShow()
    {
        $this->render('filesView',[
            'dbData' => (new FileModel())->getAll(),
        ]);
    }

    /**
     *
     */
    public function actionUpload()
    {
        /** file upload logic is delegated to FileModel class*/
        $message = (new FileModel())->upload($_FILES);

        /** to show message */
        $this->render('uploadView',[
            'message' => $message,
        ]);
    }

    /**
     * @param $filePath
     */
    public function actionDownload($filePath)
    {
        /** file download logic is delegated
         to FileModel class */
        (new FileModel())->download($filePath);
    }

    /**
     *
     */
    public function actionDeleteexpiredfiles()
    {
        /** delete expired files logic is
         delegated to FileModel class */
        (new FileModel())->deleteExpiredFiles();
    }

}