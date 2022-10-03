<?php
/**
 * Breadcrumb plugin for Craft CMS 3.1
 *
 * Generate a simple breadcrumb.
 *
 * @link      https://youandme.digital
 * @copyright Copyright (c) 2019 You & Me Digital
 */

namespace youandmedigital\breadcrumb;

use youandmedigital\breadcrumb\services\BreadcrumbService as BreadcrumbServiceService;
use youandmedigital\breadcrumb\variables\BreadcrumbVariable;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\twig\variables\CraftVariable;

use yii\base\Event;

/**
 *
 * @author    You & Me Digital
 * @package   Breadcrumb
 * @since     1.1.2
 *
 * @property  BreadcrumbServiceService $breadcrumbService
 */
class Breadcrumb extends Plugin
{
    // Static Properties
    // =========================================================================

    public static $plugin;

    // Public Properties
    // =========================================================================

    public $schemaVersion = '1.1.1';

    // Public Methods
    // =========================================================================

    public function init()
    {
        parent::init();
        self::$plugin = $this;

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
