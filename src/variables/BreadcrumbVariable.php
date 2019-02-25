<?php
/**
 * Breadcrumb plugin for Craft CMS 3.x
 *
 * tbc
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
 * @since     0.0.1
 */
class BreadcrumbVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.breadcrumb.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.breadcrumb.exampleVariable(twigValue) }}
     *
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
