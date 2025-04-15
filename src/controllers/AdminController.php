<?php

namespace worlddevs\craftmultiplequeue\controllers;

use craft\web\Controller;
use craft\web\Response;
use worlddevs\craftmultiplequeue\Plugin;

class AdminController extends Controller {
    protected array|bool|int $allowAnonymous = false;

    public function actionRelease(): Response {
        $id = $this->request->getParam('job_id');

        if( $id === null ) return $this->redirect('/admin/utilities/multiple-queue');

        Plugin::getInstance()->multipleQueues->release($id);

        return $this->redirect('/admin/utilities/multiple-queue');
    }

    public function actionReleaseAll(): Response {
        $id = $this->request->getParam('queue_id');

        Plugin::getInstance()->multipleQueues->releaseAll($id);

        return $this->redirect('/admin/utilities/multiple-queue');
    }

    public function actionRetry(): Response {
        $id = $this->request->getParam('job_id');

        if( $id === null ) return $this->redirect('/admin/utilities/multiple-queue');

        Plugin::getInstance()->multipleQueues->retry($id);

        return $this->redirect('/admin/utilities/multiple-queue');

    }

    public function actionRetryAll(): Response {
        $id = $this->request->getParam('queue_id');

        Plugin::getInstance()->multipleQueues->retryAll($id);

        return $this->redirect('/admin/utilities/multiple-queue');    
    }
}