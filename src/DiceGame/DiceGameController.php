<?php

namespace Olj\DiceGame;

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
class DiceGameController implements AppInjectableInterface
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
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        // return __METHOD__ . ", \$db is {$this->db}";

        return "Index";
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

    /**
     * Init method action
     *
     * @return string
     */
    public function initAction() : string
    {

        $session = $this->app->session;
        $request = $this->app->request;

        /**
         * Init session variables.
         */
        $session->set("current-player", null);
        $session->set("current-result", null);
        $session->set("current-acc", []);
        $session->set("human-total", null);
        $session->set("computer-total", null);
        $session->set("human-name", null);
        $session->set("player-name", null);
        $session->set("computer-name", "Datorn");
        $session->set("active-throw", null);
        $session->set("winner", null);
        $session->set("all-throws", []);
        $session->set("message", null);

        if ($request->getPost("player-name") != null) {
            $session->set('human-name', $request->getPost("player-name"));
        }

        return $this->app->response->redirect("dg2/play");
    }

    /**
     * Play method action
     *
     * @return string
     */
    public function playAction() : object
    {
        $session = $this->app->session;

        // Create a new Game object.
        $game = new Game();

        $message = "";

        if (!$session->get("current-player")) {
            $message = "Kasta en tärning för att bestämma vem som börjar.";
        }

        if ($session->get("current-player") != null
        && $session->get("active-throw") != null) {
            $player = $session->get("current-player");
            $playerName = $session->get($player . "-name");

            $message .= "</p><p><strong>" . $playerName ."s tur</strong>.";
        }


        // Histogram
        $histogram = new Histogram();
        $histogram->injectData($session->get("all-throws"));
        $game->injectHistogram($histogram);

        $title = "Tärningsspelet";

        $data = [
            "message" => $session->get("message") ?? $message ?? null,
            "humanName" => $session->get("human-name"),
            "computerName" => $session->get("computer-name"),
            "humanPoints" => $session->get("human-total"),
            "computerPoints" => $session->get("computer-total"),
            "currentAcc" => $session->get("current-acc"),
            "previousAcc" => $session->get("previous-acc") ?? null,
            "currentPlayer" => $session->get("current-player") ?? null,
            "histogram" => $game->histogram->getAsText()
        ];

        $this->app->page->add("/dice-2/play", $data);
        $this->app->page->add("/dice-2/form");
        $this->app->page->add("/dice-2/info", $data);
        $this->app->page->add("/dice-2/reset");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * This sample method action it the handler for route:
     * POST mountpoint/play
     *
     * @return object
     */
    public function playActionPost() : object
    {
        $session = $this->app->session;
        $request = $this->app->request;

        if (!$session->get("current-player")) {
            return $this->app->response->redirect("dg2/setbeginner");
        }

        if ($request->getPost("save")) {
            return $this->app->response->redirect("dg2/save");
        };

        if ($request->getPost("roll")) {
            return $this->app->response->redirect("dg2/roll");
        };
    
        $this->app->response->redirect("dg2/play");
    }


    /**
     * Roll action
     *
     * @return string
     */
    public function rollAction() : object
    {
        $session = $this->app->session;

        $player = $session->get("current-player");

        $this->app->response->redirect("dg2/" . $player);
    }


    /**
     * Save action
     *
     * @return string
     */
    public function saveAction() : object
    {
        $session = $this->app->session;

        // Create a new Game object.
        $game = new Game();

        // Inject some data from the session into the Game object.

        // Current player
        $currentPlayer = $session->get("current-player");
        if ($currentPlayer != null) {
            $game->setCurrentPlayer(new Player($currentPlayer));
        }

        // The total result for the current player.
        $currentTotal = $session->get($currentPlayer . "-total") ?? null;
        if ($currentTotal != null) {
            $game->getCurrentPlayer()->setTotal($currentTotal);
        }

        // The accumulated result which might be saved if the player chooses to do so.
        $currentAcc = $session->get("current-acc");
        if ($currentAcc != []) {
            $game->getCurrentPlayer()->setAccArr($session->get("current-acc"));
        }

        // Save result to session
        $accInteger = $game->getCurrentPlayer()->getAccInt();
        $currentPlayerTotal = $session->get($currentPlayer . "-total");
        $session->set($currentPlayer . "-total", $currentPlayerTotal + $accInteger);

        // Check if win.
        if ($session->get($currentPlayer . "-total") >= 100) {
            $player = $session->get("current-player");
            $playerName = $session->get($player . "-name");
            $session->set("winner", $playerName);
            return $this->app->response->redirect("dg2/result");
        }

        // Change player.
        $player = $session->get("current-player");
        $previousPlayerName = $session->get($player . "-name");

        if ($session->get("current-player") == "human") {
            $session->set("current-player", "computer");
        } else {
            $session->set("current-player", "human");
        };

        $session->set("previous-acc", $session->get("current-acc"));
        $session->set("current-acc", []);

        $player = $session->get("current-player");

        $playerName = $session->get($player . "-name");

        $session->set("message", "</p><p>" . $previousPlayerName . " sparade resultatet, <strong>nu är det " . $playerName . "s tur</strong>.");

        $this->app->response->redirect("dg2/play");
    }


    /**
     * Computer action
     *
     * @return string
     */
    public function computerAction() : object
    {
        $session = $this->app->session;

        // Create a new Game object.
        $game = new Game();

        var_dump($session->get("current-player"));

        // Inject some data from the session into the Game object.
        
        // Current player
        $currentPlayer = $session->get("current-player");
        if ($currentPlayer != null) {
            $game->setCurrentPlayer(new Player($currentPlayer));
        }

        // The total result for the current player.
        $currentTotal = $session->get($currentPlayer . "-total") ?? null;
        $game->getCurrentPlayer()->setTotal($currentTotal);

        // The accumulated result which might be saved if the player chooses to do so.
        $currentAcc = $session->get("current-acc");

        $game->getCurrentPlayer()->setAccArr($session->get("current-acc"));

        while (true) {
            // Generate results
            $game->getCurrentPlayer()->makeRoll();
            $currentResult = $game->getCurrentPlayer()->getCurrentResult();
    
            $currentAcc = $session->get("current-acc");
            $currentAcc[] = $currentResult;
            $session->set("current-acc", $currentAcc);
    
            foreach ($currentResult as $val) {
                $arr = $session->get("all-throws");
                $arr[] = $val;
                $session->set("all-throws", $arr);
            }
    
            $game->getCurrentPlayer()->setAccArr($session->get("current-acc"));
    
            $player = $session->get("current-player");
            $playerName = $session->get($player . "-name");
            

            var_dump($game->getCurrentPlayer()->getCurrentResultInt());
            var_dump($game->getCurrentPlayer()->getAccInt());

            if ($game->checkIfOne()) {
                $session->set("action", "slog en etta");
                break;
            }

            // Stop if the current result is over 8 or the accumulated result is over 14.
            if ($game->getCurrentPlayer()->getCurrentResultInt() > 8
                || $game->getCurrentPlayer()->getAccInt() > 14) {
                // Save result to session
                $playerTotal = $session->get($player . "-total");
                $playerTotal += $game->getCurrentPlayer()->getAccInt();
                $session->set($player . "-total", $playerTotal);

                // Check if win.
                if ($session->get($currentPlayer . "-total") >= 100) {
                    $player = $session->get("current-player");
                    $playerName = $session->get($player . "-name");
                    $session->set("winner", $playerName);
                    return $this->app->response->redirect("dg2/result");
                }

                $session->set("action", "sparade resultatet");
                break;
            }
        }

        return $this->app->response->redirect("dg2/changeplayer");
    }

    
    /**
     * Change player action
     *
     * @return string
     */
    public function changeplayerAction() : object
    {
        $session = $this->app->session;

        // Change player.
        $player = $session->get("current-player");
        $previousPlayerName = $session->get($player . "-name");

        if ($session->get("current-player") == "human") {
            $session->set("current-player", "computer");
        } else {
            $session->set("current-player", "human");
        };

        $session->set("previous-acc", $session->get("current-acc"));
        $session->set("current-acc", []);

        $player = $session->get("current-player");

        $playerName = $session->get($player . "-name");

        // Set the relevant message.
        $action = $session->get("action");
        $message = "</p><p>" . $previousPlayerName . " " . $action . ", <strong>nu är det " . $playerName . "s tur</strong>.";

        // Unset "action"
        $session->set("action", null);

        $session->set("message", $message);

        return $this->app->response->redirect("dg2/play");
    }


    /**
     * Human action
     *
     * @return string
     */
    public function humanAction() : object
    {
        $session = $this->app->session;

        // Create a new Game object.
        $game = new Game();

        // Inject some data from the session into the Game object.

        // Current player
        $currentPlayer = $session->get("current-player");
        if ($currentPlayer != null) {
            $game->setCurrentPlayer(new Player($currentPlayer));
        }

        // The total result for the current player.
        $currentTotal = $session->get($currentPlayer . "-total") ?? null;
        if ($currentTotal != null) {
            $game->getCurrentPlayer()->setTotal($currentTotal);
        }

        // The accumulated result which might be saved if the player chooses to do so.
        $currentAcc = $session->get("current-acc");
        if ($currentAcc != []) {
            $game->getCurrentPlayer()->setAccArr($session->get("current-acc"));
        }

        // echo "HUMAN action >>>";

        // Generate results.
        $game->getCurrentPlayer()->makeRoll();
        $currentResult = $game->getCurrentPlayer()->getCurrentResult();

        foreach ($currentResult as $val) {
            $arr = $session->get("all-throws");
            $arr[] = $val;
            $session->set("all-throws", $arr);
        }

        // Assign current result to session.
        $currentAcc = $session->get("current-acc");
        $currentAcc[] = $currentResult;
        $session->set("current-acc", $currentAcc);

        // Get the last player.
        $player = $session->get("current-player");
        $playerName = $session->get($player . "-name");

        // Check if there's a die with value one in the last throw.
        if ($game->checkIfOne()) {
            // If so, change player and create a message.
            $previousPlayerName = $session->get($player . "-name");

            if ($session->get("current-player") == "human") {
                $session->set("current-player", "computer");
            } else {
                $session->set("current-player", "human");
            };

            $session->set("previous-acc", $session->get("current-acc"));
            $session->set("current-acc", []);

            $player = $session->get("current-player");

            $playerName = $session->get($player . "-name");

            $message = "</p><p>" . $previousPlayerName . " slog en etta, <strong>nu är det " . $playerName . "s tur</strong>.";
        }

        $session->set("message", $message);

        $this->app->response->redirect("dg2/play");
    }


    /**
     * Result method action
     *
     * @return string
     */
    public function resultAction() : object
    {
        $session = $this->app->session;

        $title = "Tärningsspelet";

        $winner = $session->get("winner");
    
        $data = [
            "message" => "Nu är spelet slut och " . $winner . " har vunnit!",
            "humanPoints" => $session->get("human-total"),
            "computerPoints" => $session->get("computer-total"),
            "humanName" => $session->get("human-name"),
            "computerName" => $session->get("computer-name")
        ];
    
        $this->app->page->add("/dice-2/result", $data);
        $this->app->page->add("/dice-2/reset");
    
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Set beginner action
     *
     * @return string
     */
    public function setbeginnerAction() : object
    {
        $session = $this->app->session;

        // Create a new Game object.
        $game = new Game();

        // Decide beginner
        $message = "";
        
        $firstThrows = $game->decideBeginner();

        foreach ($firstThrows as $val) {
            $allThrows = $session->get("all-throws");
            $allThrows[] = $val;
            $session->set("all-throws", $allThrows);
        }

        $session->set("decide-begin-throw", [
            $session->get("human-name") => $firstThrows[0],
            $session->get("computer-name") => $firstThrows[1]
        ]);

        $firstPlayer = $game->getCurrentPlayerName();
        $session->set("current-player", $firstPlayer);
        $playerName = $session->get($firstPlayer . "-name");
        $message = "<strong>" . $playerName . " börjar</strong>.";
    
        if ($session->get("current-player") != null) {
            if ($session->get("active-throw") == null) {
                $session->set("active-throw", "begin");
            }
        }

        $session->set("message", $message);

        $this->app->response->redirect("dg2/play");
    }
}
