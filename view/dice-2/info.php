<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

$session = $app->session;
// var_dump($session);

?>
    <p><?= $humanName ?>s poäng: <?= $humanPoints ?? 0 ?></p>

    <p><?= $computerName ?>s poäng: <?= $computerPoints ?? 0 ?></p>

</div>

<div class="dice-game-right">

    <?php if ($currentAcc) : ?>
        <?php
            $player = $session->get($currentPlayer . "-name");
        ?>

        <h4><?= $player ?>s kast</h4>
        <div class="throw-div">
            <?php foreach ($currentAcc as $i => $arr) : ?>
                <div>
                    <h5>Kast <?= $i + 1 ?></h5>
                    <?php foreach ($arr as $k => $v) : ?>
                        <p><span class="die-symbol">&#x268<?= intval($v) -1 ?>;</span></p>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php elseif ($previousAcc) : ?>
        <?php
        if ($currentPlayer == "human") {
            $player = $session->get("computer-name");
        }
        if ($currentPlayer == "computer") {
            $player = $session->get("human-name");
        }
        ?>

        <h4><?= $player ?>s kast</h4>
        <div class="throw-div">
            <?php foreach ($previousAcc as $i => $arr) : ?>
                <div>
                    <h5>Kast <?= $i + 1 ?></h5>
                    <?php foreach ($arr as $k => $v) : ?>
                        <p><span class="die-symbol">&#x268<?= intval($v) -1 ?>;</span></p>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php $session->set("previous-acc", []); ?>

    <?php endif; ?>

    <?php if ($session->get("decide-begin-throw") != null) : ?>
        <h4>Första kasten</h4>
        <?php foreach ($session->get("decide-begin-throw") as $k => $v) : ?>
            <p><?= $k ?>: <span class="die-symbol">&#x268<?= $v -1 ?>;</span></p>
        <?php endforeach; ?>
        <?php $session->set("decide-begin-throw", null); ?>

    <?php endif; ?>
</div>
<div class="histogram">
        <h4>Histogram</h4>
        <?= $histogram ?>
    </div>
</div>
