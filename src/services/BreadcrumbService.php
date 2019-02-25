<?php
/**
 * Breadcrumb plugin for Craft CMS 3.x
 *
 * tbc
 *
 * @link      https://youandme.digital
 * @copyright Copyright (c) 2019 You & Me Digital
 */

namespace youandmedigital\breadcrumb\services;

use youandmedigital\breadcrumb\Breadcrumb;

use Craft;
use craft\base\Component;

/**
 * BreadcrumbService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    You & Me Digital
 * @package   Breadcrumb
 * @since     0.0.1
 */
class BreadcrumbService extends Component
{
    // Public Methods
    // =========================================================================

    public function buildBreadcrumb($settings) : array
    {

        // get and set settings array
        $homeTitle = isset($settings['homeTitle']) ? $settings['homeTitle'] : 'Home';
        $homeUrl = isset($settings['homeUrl']) ? $settings['homeUrl'] : null;
        $skipUrl = isset($settings['skipUrl']) ? $settings['skipUrl'] : null;

        // get each segment in the given URL
        $urlArray = Craft::$app->request->getSegments();
        // get sites base url
        $baseUrl = Craft::getAlias('@baseUrl');

        // set path to empty
        $path = '';

        // for each segment array as currentSlug
        foreach ($urlArray as $currentSlug) {

            // build path from current slug
            $path .= '/' . $currentSlug;
            $title = ucwords(str_replace(array('-', '_'), ' ', $currentSlug));

            // output new array and asign title and build url
            $output[] = array('title' => $title, 'url' => $baseUrl . $path);

        }

        // Reset baseURL for custom URL
        if ($homeUrl) {
            $baseUrl = $homeUrl;
        }

        $homeArray[] = array('title' => $homeTitle, 'url' => $baseUrl);
        $breadcrumbArray = array_merge($homeArray, $output);

        // Remove item from array
        if ($skipUrl) {
            $index = $skipUrl - 1 ;
            unset($breadcrumbArray[$index]);
        }

        return $breadcrumbArray;
    }
}
