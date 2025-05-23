<?php

namespace worlddevs\craftmultiplequeue\variables;

use worlddevs\craftmultiplequeue\Plugin;

class MultipleQueueVariables {
    public function queues() {
        return Plugin::getInstance()->multipleQueues->getQueues();
    }

    public function getJob($id) {
        return Plugin::getInstance()->multipleQueues->getJob($id);
    }
}