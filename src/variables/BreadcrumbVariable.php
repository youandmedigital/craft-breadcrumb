<?php
namespace youandmedigital\breadcrumb\variables;

use youandmedigital\breadcrumb\Breadcrumb;

use Craft;

class BreadcrumbVariable
{
    // Public Methods
    // =========================================================================

    public function config($settings = null)
    {
        return Breadcrumb::$plugin->breadcrumbService->buildBreadcrumb($settings);
    }
}
