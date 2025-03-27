<?php

namespace worlddevs\craftmultiplequeue\widgets;

use Craft;

class MultipleQueueWidget extends \craft\base\Widget {

    public function getBodyHtml(): ?string {
        return Craft::$app->getView()->renderTemplate('multiple-queue/_widgets/multiple-queue.twig', [
            'local'=>'variables',
        ]);
    }

    public static function displayName(): string {
        return "Queue Viewer";
    }
}