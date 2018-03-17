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

        $this->apt->installQuietly("php7.2-fpm");

        $this->apt->cli->quietlyAsUser('
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.2/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.2/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.2/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.2/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.2/fpm/php.ini
');

        (new Filesystem())->put('/etc/nginx/sites-available', '
        server {
    listen 80 default_server;
    listen [::]:80 default_server;

    root /var/www/html;
    index index.php index.html index.htm index.nginx-debian.html;

    server_name _;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
');
        (new Nginx($this->apt,$this->apt->cli))->restart();

        $this->restart();
    }

    /**
     * Restart the PhpFpm service.
     *
     * @return void
     */
    public
    function restart()
    {
        $this->apt->cli->quietly('service php7.2-fpm restart');
    }

    public
    function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the PhpFpm service.
     *
     * @return void
     */
    public
    function stop()
    {
        info('Stopping php fpm...');

        $this->apt->cli->quietly('service php7.2-fpm stop');
    }
}
