<?php
 

namespace console;
// 加载基础文件
require __DIR__ . '/../../thinkphp/base.php';

use think\Console;
use think\App;
// 执行应用
App::initCommon();
$cmds = [
    "console\\command\\Generate",
    "console\\command\\Db",
];
Console::addDefaultCommands($cmds);
Console::init();