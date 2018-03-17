<?php

namespace Provisioner;

class Php
{
    public $apt;

    /**
     * Create a new Php instance.
     *
     * @param  Apt $apt
     * @return void
     */
    public function __construct(Apt $apt)
    {
        $this->apt = $apt;
    }

    /**
     * Install the configuration files for Php.
     *
     * @return void
     */
    public function install()
    {
        info('Installing PHP...');

        $this->apt->cli->quietlyAsUser('apt install -y --force-yes php7.2-cli php7.2-dev \
php7.2-pgsql php7.2-sqlite3 php7.2-gd \
php7.2-curl php7.2-memcached \
php7.2-imap php7.2-mysql php7.2-mbstring \
php7.2-xml php7.2-zip php7.2-bcmath php7.2-soap \
php7.2-intl php7.2-readline php7.2-mcrypt');
    }

    /**
     * Restart the Php service.
     *
     * @return void
     */
    public function restart()
    {
        $this->apt->cli->quietly('service php7.2 restart');
    }

    public function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the Php service.
     *
     * @return void
     */
    public function stop()
    {
        info('Stopping php...');

        $this->apt->cli->quietly('service php7.2 stop');
    }
}
