<?php
/**
 * Breadcrumb plugin for Craft CMS 3.x
 *
 * Build a breadcrumb trail based on your current URL
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

    public function buildBreadcrumb($settings)
    {
        // get and set settings array
        $homeTitle = isset($settings['homeTitle']) ? $settings['homeTitle'] : 'Home';
        $homeUrl = isset($settings['homeUrl']) ? $settings['homeUrl'] : null;
        $skipUrlSegment = isset($settings['skipUrlSegment']) ? $settings['skipUrlSegment'] : null;
        $customFieldHandleEntryId = isset($settings['customFieldHandleEntryId']) ? $settings['customFieldHandleEntryId'] : 0;
        $customFieldHandle = isset($settings['customFieldHandle']) ? $settings['customFieldHandle'] : null;

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

        // for each segment array as currentSlug
        foreach ($urlArray as $currentSlug) {

            // build path from current slug
            $path .= '/' . $currentSlug;
            $title = ucwords(str_replace(array('-', '_'), ' ', $currentSlug));

            // output new array and asign title and build url
            $output[] = array('title' => $title, 'url' => $baseUrl . $path );

        }

        // reset baseURL for custom home URL
        if ($homeUrl) {
            $baseUrl = $homeUrl;
        }

        // create array for the home crumb...
        $homeArray[] = array('title' => $homeTitle, 'url' => $baseUrl);
        // merge home crumb with the original output
        $breadcrumbArray = array_merge($homeArray, $output);

        // add position key/value to breadcrumbArray
        foreach($breadcrumbArray as $position => &$val){
            $val['position'] = $defaultPosition++;
        }

        // remove item from array
        if ($skipUrlSegment) {
            $index = $skipUrlSegment - 1 ;
            unset($breadcrumbArray[$index]);
        }

        // if entry is an Entry, Category or Tag element
        // and id is not 0
        // and customFieldHandle is not null
        if (
            ($elementType = 'craft\elements\Entry') ||
            ($elementType = 'craft\elements\Category') ||
            ($elementType = 'craft\elements\Tag') &&
            ($customFieldHandleEntryId != 0) &&
            (!empty($customFieldHandle))
        ) {
            // get entry model based on id
            $element = Entry::find()->id($id)->one();

            // make sure the element has a custom field
            if (!empty($element->$customFieldHandle)) {

                // set title from custom field in element model
                $title = $element->$customFieldHandle;

                // move internal pointer to the end of the array
                end($breadcrumbArray);
                // fetch last key in array...
                $key = key($breadcrumbArray);
                // set new value...
                $breadcrumbArray[$key]['title'] = $title;
            }

        }

        // return output
        return $breadcrumbArray;
    }
}
