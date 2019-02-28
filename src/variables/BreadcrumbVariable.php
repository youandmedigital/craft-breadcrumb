<?php
/**
 * Breadcrumb plugin for Craft CMS 3.1
 *
 * Generate a simple breadcrumb based on your URL segments.
 *
 * @link      https://youandme.digital
 * @copyright Copyright (c) 2019 You & Me Digital
 */

namespace youandmedigital\breadcrumb\variables;

use youandmedigital\breadcrumb\Breadcrumb;

use Craft;

/**
 * Breadcrumb Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.breadcrumb }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    You & Me Digital
 * @package   Breadcrumb
 * @since     1.0.1
 */
class BreadcrumbVariable
{
    // Public Methods
    // =========================================================================

    public function config($settings = NULL)
    {
        return Breadcrumb::$plugin->breadcrumbService->buildBreadcrumb($settings);
    }
}
