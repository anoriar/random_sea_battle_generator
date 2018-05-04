<?php
    define('ROOT', dirname(__FILE__));
    require_once(ROOT . '/game_generator.php');

    $game = new RandomGameGenerator();
    $field = $game->getField();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SeaBattleGenerator</title>
    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <div class="board">
        <?php
            for ($i = 0; $i < count($field); $i++) {
                for ($j = 0; $j < count($field[$i]); $j++) {
                    if ($field[$i][$j] == 1)
                        echo "<div class='cell active'></div>";
                    else
                        echo "<div class='cell'></div>";
                }
                echo "<br>";
            }
        ?>
    </div>
</body>
</html>