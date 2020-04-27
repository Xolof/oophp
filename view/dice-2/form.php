<?php
$session = $app->session;
?>

<form action="" method="post">


<?php

if ($session->get("current-player") == "human"
    && $session->get("current-acc") != null) : ?>
    <input type="submit" name="save" value="Spara">
<?php endif ?>

<?php if ($session->get("current-player") == "computer") : ?>
    <input type="submit" name="roll" value="Låt datorn kasta">
<?php else : ?>
    <input type="submit" name="roll" value="Kasta">
<?php endif; ?>

</form>
