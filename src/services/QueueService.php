<?php

namespace worlddevs\craftmultiplequeue\services;

use Craft;
use yii\base\Component;

class QueueService extends Component {
    public function getQueues(): array {
        $queues = [];

        foreach(Craft::$app->components as $component) {
            if( is_array($component) && $component['class'] == 'craft\\queue\\Queue' ) {
                $queues[] = new \craft\queue\Queue([
                    'channel'=>empty($component['channel'])?'default':$component['channel']
                ]);
            }
        }

        return $queues;
    }

    public function getJob($id): ?array {
        $queues = $this->getQueues();

        foreach($queues as $queue) {
            try {
                $job = $queue->getJobDetails($id);

                return $job;
            }
            catch(\Exception $e) {
                // do nothing, next queue
            }
        }

        return null;
    }
}