<?php

namespace worlddevs\craftmultiplequeue;

use Craft;
use craft\base\Model;
use craft\base\Plugin as BasePlugin;
use worlddevs\craftmultiplequeue\models\Settings;
use yii\base\Event;
use craft\services\Utilities;
use craft\events\RegisterComponentTypesEvent;
use worlddevs\craftmultiplequeue\utility\MultipleQueueUtility;
use worlddevs\craftmultiplequeue\services\QueueService;
use craft\web\twig\variables\CraftVariable;
use worlddevs\craftmultiplequeue\variables\MultipleQueueVariables;

/**
 * MultipleQueue plugin
 *
 * @method static Plugin getInstance()
 * @method Settings getSettings()
 * @author WORLD Developers <world.developers@wng.org> <world.developers@wng.org>
 * @copyright WORLD Developers <world.developers@wng.org>
 * @license https://craftcms.github.io/license/ Craft License
 */
class Plugin extends BasePlugin
{
    public string $schemaVersion = '1.0.0';
    public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                'multipleQueues'=>QueueService::class
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function() {
            // ...
        });

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $ev) {
                $var = $ev->sender;

                $var->set('mqueues', MultipleQueueVariables::class);
            }
        );

        Event::on(
            Utilities::class,
            Utilities::EVENT_REGISTER_UTILITY_TYPES,
            function(RegisterComponentTypesEvent $event) {
                $event->types[] = MultipleQueueUtility::class;
            }
        );
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('multiple-queue/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/4.x/extend/events.html to get started)
    }
}
