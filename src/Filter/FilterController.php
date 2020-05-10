<?php

namespace Olj\Filter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class FilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";

        // Use $this->app to access the framework services.
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $filter = new MyTextFilter();

        $text = <<<EOD


### Förevisning av Markdown

Den här sidan är skriven i markdown.

Jag valde att inte låta användaren skriva någon HTML själv. Metoden `parse()`
gör `strip_tags()` på innehållet innan de valda filtren appliceras.

Så det går inte att busa med javascript.

<script>alert('busigt meddelande');</script>

### Förevisning av BBCode

BBCode verkar funka bra med Markdown.

[i]Mumintrollet[/i] har en [b]fet[/b] [u]moped[/u].

Här är elePHPanten:

[img]https://spyrestudios.com/wp-content/uploads/PHP-elephant-150x150.jpg[/img]

[url]https://www.php.net/[/url]

### Länkar med Markdown

Det verkar som att `makeClickable` kan krocka med markdown. Därför har jag styrt det så att
om användaren väljer att skriva markdown kommer inte `makeClickable` exekveras.
Användaren får då skriva länkarna i markdown.

Till exempel så här:
[Det magiska numret](http://www.google.com/search?rls=en&q=42&ie=utf-8&oe=utf-8&hl=en)

### Demo av makeClickable och nl2br

Även `nl2br` verkar krocka med Markdown, så även här gjorde jag så att om både `nl2br` och `markdown` har valts så exekveras inte `nl2br`.

I implementationen i CMS:et kan det vara trevligt att ge användaren ett meddelande om denne försöker använda filter som krockar.

`makeClickable` och `nl2br` verkar fungera bra tillsammans så de får en egen vy.

[Demo av makeClickable och nl2br](filter/clicknl2br)

EOD;

        try {
            $html = $filter->parse($text, ["markdown", "nl2br", "bbcode", "link"]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $title = "Filter demo";

        $this->app->page->add("filter/index", ["html" => $html]);
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * Method action for demo of makeClickable() and nl2br().
     *
     * @return object
     */
    public function clicknl2brAction() : object
    {
        $filter = new MyTextFilter();

        $text = <<<EOD
Detta är en demo av metoderna makeClickable() and nl2br() i klassen MyTextFilter.

http://www.google.com/search?rls=en&q=42&ie=utf-8&oe=utf-8&hl=en.

A quick look at http://en.wikipedia.org/wiki/URI_scheme#Generic_syntax is helpful.

There is no place like 127.0.0.1! Except maybe http://news.bbc.co.uk/1/hi/england/surrey/8168892.stm?

old pond\nfrog leaps in\nwater's sound

EOD;

        try {
            $html = $filter->parse($text, ["link", "nl2br"]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        $title = "Filter demo";

        $this->app->page->add("filter/index", ["html" => $html]);
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Debug method action
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";

        return "Debug";
    }
}
