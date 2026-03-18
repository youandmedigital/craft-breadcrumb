<?php
namespace youandmedigital\breadcrumb;

use youandmedigital\breadcrumb\services\BreadcrumbService;
use youandmedigital\breadcrumb\variables\BreadcrumbVariable;

use Craft;
use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 * @property BreadcrumbService $breadcrumbService
 */
class Breadcrumb extends Plugin
{
    // Public Properties
    // =========================================================================

    public string $schemaVersion = '1.1.1';

    // Public Methods
    // =========================================================================

    public function getBreadcrumbService(): BreadcrumbService
    {
        return $this->get('breadcrumbService');
    }

    public function init()
    {
        parent::init();

        // Register services
        $this->setComponents([
            'breadcrumbService' => BreadcrumbService::class,
        ]);

        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('breadcrumb', BreadcrumbVariable::class);
            }
        );

        Craft::info(
            Craft::t(
                'breadcrumb',
                '[ {name} ] Plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

}
