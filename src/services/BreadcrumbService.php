<?php
/**
 * Breadcrumb plugin for Craft CMS 3.x
 *
 * A simple plugin that builds a breadcrumb trail based on your URL
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
        $skipUrlSegment = isset($settings['$skipUrlSegment']) ? $settings['$skipUrlSegment'] : null;

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

        // Create array for the home crumb...
        $homeArray[] = array('title' => $homeTitle, 'url' => $baseUrl);
        // Merge home crumb with the original output
        $breadcrumbArray = array_merge($homeArray, $output);

        // Remove item from array
        if ($skipUrlSegment) {
            $index = $skipUrlSegment - 1 ;
            unset($breadcrumbArray[$index]);
        }

        // Return output
        return $breadcrumbArray;
    }
}
