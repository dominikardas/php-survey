<?php
    require "lessc.inc.php";

    $less = new lessc;
    $less->setFormatter("compressed");
    echo $less->compileFile("style.less", "style.css");