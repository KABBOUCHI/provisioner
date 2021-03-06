<?php

namespace Provisioner;

class MySql
{
    public $apt;

    /**
     * Create a new MySql instance.
     *
     * @param  Apt $apt
     * @return void
     */
    public function __construct(Apt $apt)
    {
        $this->apt = $apt;
    }

    /**
     * Install the configuration files for MySql.
     *
     * @return void
     */
    public function install()
    {
        if (! $this->apt->installed('mariadb-server')) {
            $this->apt->cli->quietly('debconf-set-selections <<< "mariadb-server-10.0 mysql-server/data-dir select \'\'"');
            $this->apt->cli->quietly('debconf-set-selections <<< "mariadb-server-10.0 mysql-server/root_password password ABC123456789"');
            $this->apt->cli->quietly('debconf-set-selections <<< "mariadb-server-10.0 mysql-server/root_password_again password ABC123456789"');

            $this->apt->installQuietly('mariadb-server');

            $this->apt->cli->quietly('echo "" >> /etc/mysql/my.cnf');
            $this->apt->cli->quietly('echo "[mysqld]" >> /etc/mysql/my.cnf');
            $this->apt->cli->quietly('echo "character-set-server = utf8" >> /etc/mysql/my.cnf');
        }
    }

    /**
     * Restart the MySql service.
     *
     * @return void
     */
    public function restart()
    {
        $this->apt->cli->quietly('service mysql restart');
    }

    public function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the MySql service.
     *
     * @return void
     */
    public function stop()
    {
        info('Stopping mysql...');

        $this->apt->cli->quietly('service mysql stop');
    }
}
