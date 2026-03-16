<?php
namespace youandmedigital\breadcrumb\variables;

use youandmedigital\breadcrumb\Breadcrumb;

class BreadcrumbVariable
{
    // Public Methods
    // =========================================================================

    public function config($settings = null)
    {
        return Breadcrumb::getInstance()->breadcrumbService->buildBreadcrumb($settings);
    }
}
