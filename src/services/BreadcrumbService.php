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
 * @since     1.0.3
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
        $skipUrlSegment = isset($settings['skipUrlSegment']) ? $settings['skipUrlSegment'] : null;
        $customFieldHandleEntryId = isset($settings['customFieldHandleEntryId']) ? $settings['customFieldHandleEntryId'] : 0;
        $customFieldHandle = isset($settings['customFieldHandle']) ? $settings['customFieldHandle'] : null;
        $limit = isset($settings['limit']) ? $settings['limit'] : null;

        // get each segment in the given URL
        $urlArray = Craft::$app->request->getSegments();
        // get site baseUrl value
        $baseUrl = Craft::getAlias('@baseUrl');
        // get element type
        $elementType = Craft::$app->elements->getElementTypeById($customFieldHandleEntryId);

        // set path to empty
        $path = '';
        // set default position key
        $defaultPosition = 1;
        // set empty array
        $homeArray = array();
        $output = array();

        // for each segment in array
        foreach ($urlArray as $segment) {

            // build path from current segment
            $path .= '/' . $segment;
            $title = ucwords(str_replace(array('-', '_'), ' ', $segment));

            // output new array... set title and build url
            $output[] = array('title' => $title, 'url' => $baseUrl . $path);

        }

        // reset baseURL for custom homeURL
        if ($homeUrl) {
            $baseUrl = $homeUrl;

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

        // limit and return the amount of results if set
        if ($limit) {
            return array_slice($breadcrumbArray, 0, $limit);

        }

        // return output
        return $breadcrumbArray;
    }
}
