<?php
/**
 * Breadcrumb plugin for Craft CMS 3.1
 *
 * Generate a simple breadcrumb from a URL.
 *
 * @link      https://youandme.digital
 * @copyright Copyright (c) 2019 You & Me Digital
 */

namespace youandmedigital\breadcrumb\services;

use youandmedigital\breadcrumb\Breadcrumb;
use craft\elements\Entry;
use craft\elements\Category;

use Craft;
use craft\base\Component;

/**
 * BreadcrumbService Service
 *
 * @author    You & Me Digital
 * @package   Breadcrumb
 * @since     1.0.4
 */
class BreadcrumbService extends Component
{
    // Public Methods
    // =========================================================================

    public function buildBreadcrumb($settings) : array
    {
        // get and set settings array
        $homeTitle = $settings['homeTitle'] ?? 'Home';
        $customBaseUrl = $settings['homeUrl'] ?? $settings['customBaseUrl'] ?? null;
        $skipUrlSegment = $settings['skipUrlSegment'] ?? null;
        $customFieldHandleEntryId = $settings['customFieldHandleEntryId'] ?? 0;
        $customFieldHandle = $settings['customFieldHandle'] ?? null;
        $limit = $settings['limit'] ?? null;
        $lastSegmentTitle = $settings['lastSegmentTitle'] ?? null;

        // get each segment in the given URL
        $urlArray = Craft::$app->request->getSegments();

        // get site baseUrl value
        $currentSite = Craft::$app->getSites()->getCurrentSite();
        $baseUrl = rtrim($currentSite->getBaseUrl(),'/');

        // get element type
        $elementType = Craft::$app->elements->getElementTypeById($customFieldHandleEntryId);

        // set defaults
        $defaultPosition = 1;
        $path = '';
        $homeArray = array();
        $output = array();
        $element = '';

        // reset baseURL for custom customBaseUrl
        if ($customBaseUrl) {
            $baseUrl = $customBaseUrl;
        }

        // for each segment in array
        foreach ($urlArray as $segment) {
            // build path from current segment
            $path .= '/' . $segment;
            $title = ucwords(str_replace(array('-', '_'), ' ', $segment));
            // output new array... set title and build url
            $output[] = array('title' => $title, 'url' => $baseUrl . $path);
        }

        // create array for the home crumb...
        $homeArray[] = array('title' => $homeTitle, 'url' => $baseUrl);
        // merge home crumb with the original output
        $breadcrumbArray = array_merge($homeArray, $output);

        // add position key/value to breadcrumbArray
        foreach ($breadcrumbArray as $position => &$val) {
            $val['position'] = $defaultPosition++;
        }

        // remove segment from array
        if ($skipUrlSegment) {
            $index = $skipUrlSegment - 1;
            unset($breadcrumbArray[$index]);
        }

        // set custom field for an Entry element
        if (
            ($elementType == 'craft\elements\Entry') &&
            ($customFieldHandleEntryId != 0) &&
            (!empty($customFieldHandle))
        ) {
            // get entry model based on id
            $element = Entry::find()->id($customFieldHandleEntryId)->one();
        }

        // set custom field for an Category element
        if (
            ($elementType == 'craft\elements\Category') &&
            ($customFieldHandleEntryId != 0) &&
            (!empty($customFieldHandle))
        ) {
            // get entry model based on id
            $element = Category::find()->id($customFieldHandleEntryId)->one();
        }

        // if the element returns a value...
        if (!empty($element->$customFieldHandle)) {
            // move internal pointer to the end of the array
            end($breadcrumbArray);
            // fetch last key in array...
            $key = key($breadcrumbArray);
            // set title with new value
            $breadcrumbArray[$key]['title'] = $element->$customFieldHandle;
        }

        // set last segment title
        if ($lastSegmentTitle) {
            // move internal pointer to the end of the array
            end($breadcrumbArray);
            // fetch last key in array...
            $key = key($breadcrumbArray);
            // set title with new value
            $breadcrumbArray[$key]['title'] = $lastSegmentTitle;
        }

        // limit and return the amount of results if set
        if ($limit) {
            return array_slice($breadcrumbArray, 0, $limit);
        }

        // return output
        return $breadcrumbArray;
    }
}
