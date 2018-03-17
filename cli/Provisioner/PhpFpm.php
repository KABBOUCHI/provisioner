<?php

namespace Provisioner;

class PhpFpm
{
    public $apt;

    /**
     * Create a new PhpFpm instance.
     *
     * @param  Apt $apt
     * @return void
     */
    public function __construct(Apt $apt)
    {
        $this->apt = $apt;
    }

    /**
     * Install the configuration files for PhpFpm.
     *
     * @return void
     */
    public function install()
    {
        info('Installing PHP FPM...');

        $this->apt->installQuietly('php7.2-fpm');

        $this->apt->cli->quietlyAsUser('
        # Tweak Some PHP-FPM Settings

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.2/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.2/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.2/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.2/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.2/fpm/php.ini

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = forge/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = forge/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = forge/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.2/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.2/fpm/pool.d/www.conf

# Configure Primary Nginx Settings

sed -i "s/user www-data;/user forge;/" /etc/nginx/nginx.conf
sed -i "s/worker_processes.*/worker_processes auto;/" /etc/nginx/nginx.conf
sed -i "s/# multi_accept.*/multi_accept on;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 64;/" /etc/nginx/nginx.conf
        ');

        $this->restart();
    }

    /**
     * Restart the PhpFpm service.
     *
     * @return void
     */
    public function restart()
    {
        $this->apt->cli->quietly('service php7.2-fpm restart');
    }

    public function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the PhpFpm service.
     *
     * @return void
     */
    public function stop()
    {
        info('Stopping php fpm...');

        $this->apt->cli->quietly('service php7.2-fpm stop');
    }
}
