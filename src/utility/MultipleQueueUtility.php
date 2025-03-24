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
        return Craft::$app->view->renderTemplate(
            'multiple-queue/_util/dashboard.twig',
            [],
            View::TEMPLATE_MODE_CP
        );
    }
}