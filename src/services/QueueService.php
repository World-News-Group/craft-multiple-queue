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
                    'channel'=>empty($component['channel'])?'queue':$component['channel']
                ]);
            }
        }

        return $queues;
    }

    public function release($id): bool {
        $queue = $this->getQueueByJobId($id);

        if( $queue !== null ) {
            $queue->release($id);  
            return true;     
        }

        return false;
    }

    public function releaseAll($queue_id): bool {
        $queue = $this->getQueue($queue_id);

        if( $queue !== null ) {
            $queue->releaseAll();  
            return true;     
        }

        return false;

    }

    public function retry($id): bool {
        $queue = $this->getQueueByJobId($id);

        if( $queue !== null ) {
            $queue->retry($id);  
            return true;     
        }

        return false;
    }

    public function retryAll($queue_id): bool {
        $queue = $this->getQueue($queue_id);

        if( $queue !== null ) {
            $queue->retryAll();  
            return true;     
        }

        return false;

    }

    public function getQueueByJobId($id): ?\craft\queue\Queue {
        $queues = $this->getQueues();

        foreach($queues as $queue) {
            try {
                $queue->getJobDetails($id);

                return $queue;
            }
            catch(\Exception $e) {
                // do nothing, next queue
            }
        }

        return null;
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

    public function getQueue($id): ?\craft\queue\Queue {
        $queues = $this->getQueues();

        foreach($queues as $queue) {
            if( $queue->channel == $id ) {
                return $queue;
            }
        }

        return null;
    }    
}