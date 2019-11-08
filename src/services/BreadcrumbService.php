<?php
/**
 * Breadcrumb plugin for Craft CMS 3.1
 *
 * Generate a simple breadcrumb.
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
 * @since     1.1.1
 */
class BreadcrumbService extends Component
{
    // Public Methods
    // =========================================================================

    public function buildBreadcrumb($settings) : array
    {
        // get and set settings
        $homeTitle = $settings['homeTitle'] ?? 'Home';
        $customBaseUrl = $settings['homeUrl'] ?? $settings['customBaseUrl'] ?? null;
        $skipUrlSegment = $settings['skipUrlSegment'] ?? null;
        $customFieldHandleEntryId = $settings['customFieldHandleEntryId'] ?? 0;
        $customFieldHandle = $settings['customFieldHandle'] ?? null;
        $limit = $settings['limit'] ?? null;
        $lastSegmentTitle = $settings['lastSegmentTitle'] ?? null;

        // turn each segment in the url into an array
        $urlArray = Craft::$app->request->getSegments();

        // get site baseUrl
        $currentSite = Craft::$app->getSites()->getCurrentSite();
        $baseUrl = rtrim($currentSite->getBaseUrl(), '/');

        // set defaults
        $defaultPosition = 1;
        $path = '';
        $homeArray = array();
        $output = array();
        $hasCustomFieldSetting = false;

        // check if customFieldHandle is being used
        if (
            ($customFieldHandleEntryId != 0) &&
            (!empty($customFieldHandle))
        ) {
            $hasCustomFieldSetting = true;
        }

        // set custom baseUrl
        if (
            $customBaseUrl
        ) {
            $baseUrl = $customBaseUrl;
        }

        // for each segment in the array
        foreach ($urlArray as $segment) {

            // build path from current segment
            $path .= '/' . $segment;

            // generate title from URL segment
            $generatedTitle = str_replace(array('-', '_'), ' ', $segment);

            // check to see if the segment belongs to an element
            $isElement = Craft::$app->elements->getElementByUri(ltrim($path, '/'));

            // if isElement belongs to element interface...
            if (
                $isElement instanceof \craft\base\ElementInterface
            ) {

                // check if isElement has a traditional title
                if (
                    $isElement->hasTitles()
                ) {

                    // check if hasCustomFieldSetting returns true
                    if (
                        $hasCustomFieldSetting
                    ) {
                        // set title to customFieldHandle if it returns a value, otherwise fallback to element title
                        $title = $isElement->$customFieldHandle ? $isElement->$customFieldHandle : $isElement->title;
                    }
                    // otherwise use the title field
                    else {
                        $title = $isElement->title;
                    }

                }
                // if isElement has no title
                else {

                    // check if hasCustomFieldSetting returns true
                    if (
                        $hasCustomFieldSetting
                    ) {
                        // set title to customFieldHandle if it returns a value, otherwise fallback to URL segment
                        $title = $isElement->$customFieldHandle ? $isElement->$customFieldHandle : $generatedTitle;
                    }
                    // otherwise use the URL segment
                    else {
                        $title = $generatedTitle;
                    }

                }

            }
            // otherwise, we're not dealing with an element
            else {
                // we're out of options. build the title from the URL segment
                $title = $generatedTitle;
            }

            // output new array... set title and build URL
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

        // last segment title
        if (
            $lastSegmentTitle
        ) {
            // move internal pointer to the end of the array
            end($breadcrumbArray);
            // fetch last key in array...
            $key = key($breadcrumbArray);
            // set title with new value
            $breadcrumbArray[$key]['title'] = $lastSegmentTitle;
        }

        // skip URL segment
        if (
            $skipUrlSegment
        ) {
            $index = $skipUrlSegment - 1;
            unset($breadcrumbArray[$index]);
        }

        // limit and return the amount of results
        if (
            $limit
        ) {
            return array_slice($breadcrumbArray, 0, $limit);
        }

        // return breadcrumb array
        return $breadcrumbArray;
    }
}
