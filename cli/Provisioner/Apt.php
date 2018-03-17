<?php

namespace Provisioner;

class Apt
{
    public $cli;
    public $files;

    /**
     * Create a new Brew instance.
     *
     * @param  CommandLine $cli
     * @return void
     */
    public function __construct(CommandLine $cli)
    {
        $this->cli = $cli;
    }

    /**
     * Determine if the given formula is installed.
     *
     * @param  string $package
     * @return bool
     */
    public function installed($package)
    {
        return in_array($package, explode(PHP_EOL, $this->cli->runAsUser('apt list --installed | grep '.$package)));
    }

    public function install($package)
    {
        info("Installing {$package}...");

        $this->cli->runAsUser('apt install -y '.$package);
    }

    public function update()
    {
        $this->cli->runAsUser('apt-get update && apt-get upgrade -y');
    }

    public function installQuietly($package)
    {
        info("Installing {$package}...");

        $this->cli->quietlyAsUser('apt install -y '.$package);
    }
}
