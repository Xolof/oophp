<?php

namespace Olj\Filter;

// Get Markdown class
use Michelf\Markdown;

/**
 * Filter and format text content.
 */
class MyTextFilter
{
    /**
     * @var array $filters Supported filters with method names of 
     *                     their respective handler.
     */
    private $filters = [
        "bbcode"    => "bbcode2html",
        "link"      => "makeClickable",
        "markdown"  => "markdown",
        "nl2br"     => "nl2br",
    ];

    /**
     * Get the allowed filters.
     * 
     * @return array with the alowed filters.
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * First, strip tags off thte text.
     * Then, call each filter on the text and return the processed text.
     *
     * @param string $text   The text to filter.
     * @param string  $filter Comma separated string with filters to use.
     *
     * @return string with the formatted text.
     */
    public function parse($text, $filter)
    {
        // // In a CMS, this check should be done before saving the text to the db.     
        // if (in_array("markdown", $filter) && in_array("nl2br", $filter)) {
        //     throw new Exception("Filters 'markdown' and 'nl2br' are not compatible.");
        // };

        // Strip all tags.
        $text = $this->strip($text);

        if ($filter === null or $filter === "") {
            return $text;
        }

        $filter = explode(",", $filter);

        $filter = $this->removeIncompatibleFilters($filter);

        // Apply the filters.
        foreach ($filter as $key) {
            $method = $this->filters[$key];
            $text = $this->{$method}($text);
        };

        return $text;
    }

    private function removeIncompatibleFilters($filter)
    {
        if (in_array("markdown", $filter) && in_array("nl2br", $filter)) {
            foreach ($filter as $key => $val) {
                if ($filter[$key] === "nl2br") {
                    unset($filter[$key]);
                }
            }
        };

        if (in_array("markdown", $filter) && in_array("link", $filter)) {
            foreach ($filter as $key => $val) {
                if ($filter[$key] === "link") {
                    unset($filter[$key]);
                }
            }
        };
        
        return $filter;
    }

    /**
     * Helper, BBCode formatting converting to HTML.
     *
     * @param string $text The text to be converted.
     *
     * @return string the formatted text.
     */
    public function bbcode2html($text)
    {
        $search = [
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        ];

        $replace = [
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        ];

        return preg_replace($search, $replace, $text);
    }



    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            function ($matches) {
                return "<a href=\"{$matches[0]}\">{$matches[0]}</a>";
            },
            $text
        );
    }



    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     * 
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function markdown($text)
    {
        return Markdown::defaultTransform($text);
    }



    /**
     * For convenience access to nl2br formatting of text.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function nl2br($text)
    {
        return nl2br($text);
    }

    /**
     * Access to the PHP-function strip_tags
     * 
    * @param string $text The text that should be formatted.
     *
     * @return string the formatted text.
     */
    public function strip($text)
    {
        return strip_tags($text);
    }
}
