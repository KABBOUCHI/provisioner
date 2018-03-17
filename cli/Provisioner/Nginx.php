<?php

namespace Provisioner;

class Nginx
{
    const NGINX_CONF = '/usr/local/etc/nginx/nginx.conf';
    var $apt;
    var $cli;
    var $files;
    var $configuration;
    var $site;

    /**
     * Create a new Nginx instance.
     *
     * @param  Apt $apt
     * @param  CommandLine $cli
     * @return void
     */
    function __construct(Apt $apt, CommandLine $cli)
    {
        $this->cli = $cli;
        $this->apt = $apt;
    }

    /**
     * Install the configuration files for Nginx.
     *
     * @return void
     */
    function install()
    {
        if (!$this->apt->installed('nginx')) {
            $this->apt->install('nginx');
        }
    }

    /**
     * Restart the Nginx service.
     *
     * @return void
     */
    function restart()
    {

        $this->cli->quietly('service nginx restart');
    }

    function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the Nginx service.
     *
     * @return void
     */
    function stop()
    {
        info('Stopping nginx...');

        $this->cli->quietly('service nginx stop');
    }
}
