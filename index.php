<?php

require("ScriptTest.php");

$ScriptTest = new ScriptTest;
$test = $ScriptTest->testfindOneOrWhere();
if ($test) {
    return var_dump($test);
} else {
    echo "failed";
}


?>