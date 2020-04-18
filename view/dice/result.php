<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1>Tärningsspelet</h1>

<?php if ($message) : ?>
    <p><?= $message ?></p>
<?php endif; ?>

<p><?= $humanName ?>s poäng:<?= $humanPoints ?? 0 ?></p>

<p><?= $computerName ?>s poäng:<?= $computerPoints ?? 0 ?></p>
