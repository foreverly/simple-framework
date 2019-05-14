<?php
define('ACCESS',true);

//载入核心启动类
include __DIR__ . "/../../framework/core/Framework.php";

// 由于采用命名空间，访问类必须带上命名空间
framework\core\Framework::run();