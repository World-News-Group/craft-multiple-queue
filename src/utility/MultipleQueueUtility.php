<?php

namespace worlddevs\craftmultiplequeue\utility;

use Craft;
use craft\base\Utility;
use craft\web\View;

class MultipleQueueUtility extends Utility {
    public static function displayName(): string {
        return Craft::t('multiple-queue', 'MutipleQueue');
    }

    public static function id(): string {
        return 'multiple-queue';
    }

    public static function iconPath(): ?string {
        return null;
    }

    public static function contentHtml(): string {
        $id = \Craft::$app->request->getParam('id');

        if( $id === null ) {
            return Craft::$app->view->renderTemplate(
                'multiple-queue/dashboard.twig',
                [],
                View::TEMPLATE_MODE_CP
            );
        }
        else {
            return Craft::$app->view->renderTemplate(
                'multiple-queue/detail.twig',
                ['id'=>$id],
                View::TEMPLATE_MODE_CP
            );            
        }
    }
}