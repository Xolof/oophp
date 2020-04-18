<form action="" method="post">

<?php if ($_SESSION["dg-state"]["active-throw"] == "active"
            && $_SESSION["dg-state"]["current-player"] == "human"
            && $_SESSION["dg-state"]["current-acc"] != null) : ?>
    <input type="submit" name="save" value="Spara">
<?php endif ?>

<?php if ($_SESSION["dg-state"]["current-player"] == "computer") : ?>
    <input type="submit" name="roll" value="Låt datorn kasta">
<?php else : ?>
    <input type="submit" name="roll" value="Kasta">
<?php endif; ?>

</form>
