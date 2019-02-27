<?php
/**
 * Breadcrumb plugin for Craft CMS 3.1
 *
 * Generate a simple breadcrumb based on your URL segments.
 *
 * @link      https://youandme.digital
 * @copyright Copyright (c) 2019 You & Me Digital
 */

namespace youandmedigital\breadcrumb\services;

use youandmedigital\breadcrumb\Breadcrumb;
use craft\elements\Entry;

use Craft;
use craft\base\Component;

/**
 * BreadcrumbService Service
 *
 * @author    You & Me Digital
 * @package   Breadcrumb
 * @since     1.0.0
 */
class BreadcrumbService extends Component
{
    // Public Methods
    // =========================================================================

    public function buildBreadcrumb($settings)
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
        // get sites base url
        $baseUrl = Craft::getAlias('@baseUrl');
        // get element type
        $elementType = Craft::$app->elements->getElementTypeById($customFieldHandleEntryId);

        // set path to empty
        $path = '';
        // set default position key
        $defaultPosition = 1;

        // for each segment in array
        foreach ($urlArray as $segment) {

            // build path from current segment
            $path .= '/' . $segment;
            $title = ucwords(str_replace(array('-', '_'), ' ', $segment));

            // output new array and asign title and build url
            $output[] = array('title' => $title, 'url' => $baseUrl . $path );

        }

        // reset baseURL for custom home URL
        if ($homeUrl) {
            $baseUrl = $homeUrl;
            Craft::info(
                '[ Breadcrumb ] homeUrl active. Setting URL to ' . $homeUrl,
                __METHOD__
            );
        }

        // create array for the home crumb...
        $homeArray[] = array('title' => $homeTitle, 'url' => $baseUrl);
        // merge home crumb with the original output
        $breadcrumbArray = array_merge($homeArray, $output);

        // add position key/value to breadcrumbArray
        foreach($breadcrumbArray as $position => &$val){
            $val['position'] = $defaultPosition++;
        }

        // remove segment from array
        if ($skipUrlSegment) {
            $index = $skipUrlSegment - 1 ;
            unset($breadcrumbArray[$index]);

            Craft::info(
                '[ Breadcrumb ] skipUrlSegment active. Skipping segment ' . $index,
                __METHOD__
            );
        }

        // use custom field for last crumb title
        // if entry is an Entry, Category or Tag element
        // and customFieldHandleEntryId is not 0
        // and customFieldHandle is not null
        if (
            ($elementType = 'craft\elements\Entry') ||
            ($elementType = 'craft\elements\Category') ||
            ($elementType = 'craft\elements\Tag') &&
            ($customFieldHandleEntryId != 0) &&
            (!empty($customFieldHandle))
        ) {
            // get entry model based on id
            $element = Entry::find()->id($customFieldHandleEntryId)->one();

            // make sure the element has a custom field
            if (!empty($element->$customFieldHandle)) {

                // move internal pointer to the end of the array
                end($breadcrumbArray);
                // fetch last key in array...
                $key = key($breadcrumbArray);
                // set new value...
                $breadcrumbArray[$key]['title'] = $element->$customFieldHandle;
            } else {
                Craft::error(
                    '[ Breadcrumb ] Handle for custom field not found. Please check your settings and try again',
                    __METHOD__
                );
            }

        }

        // limit and return the amount of results if set
        if ($limit) {
            Craft::info(
                '[ Breadcrumb ] limit active. Limiting results by ' . $limit,
                __METHOD__
            );
            return array_slice($breadcrumbArray, 0, $limit);
        }

        // return output
        return $breadcrumbArray;
    }
}
