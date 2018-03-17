<?php

namespace Provisioner;

class Nginx
{
    const NGINX_CONF = '/usr/local/etc/nginx/nginx.conf';
    public $apt;
    public $cli;
    public $files;
    public $configuration;
    public $site;

    /**
     * Create a new Nginx instance.
     *
     * @param  Apt $apt
     * @param  CommandLine $cli
     * @return void
     */
    public function __construct(Apt $apt, CommandLine $cli)
    {
        $this->cli = $cli;
        $this->apt = $apt;
    }

    /**
     * Install the configuration files for Nginx.
     *
     * @return void
     */
    public function install()
    {
        if (! $this->apt->installed('nginx')) {
            $this->apt->installQuietly('nginx');
        }
    }

    /**
     * Restart the Nginx service.
     *
     * @return void
     */
    public function restart()
    {
        $this->cli->quietly('service nginx restart');
    }

    public function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the Nginx service.
     *
     * @return void
     */
    public function stop()
    {
        info('Stopping nginx...');

        $this->cli->quietly('service nginx stop');
    }
}
