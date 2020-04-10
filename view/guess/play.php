<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<h1>Make a guess</h1>

<?php if ($error) : ?>
    <p>Error: <?= $error ?></p>
<?php endif; ?>

<?php if ($result) : ?>
    <p>Result: <?= $result ?></p>
<?php endif; ?>

<?php if ($secret_number) : ?>
    <p>Secret number: <?= $secret_number ?></p>
<?php endif; ?>

<?php if ($tries) : ?>
    <p>Tries: <?= $tries ?></p>
<?php endif; ?>

