<?php

namespace Provisioner;

class Serve
{
    public function __construct()
    {
    }

    public function run($token)
    {
        info('Provisioner running...');

        passthru($this->serverCommand());
    }

    protected function serverCommand()
    {
        return 'php -S 0.0.0.0:4444 '.PROVISIONER_HOME_PATH.'/server/index.php';
    }
}
