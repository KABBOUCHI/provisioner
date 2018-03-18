<?php

namespace Provisioner;

class Redis
{
    public $apt;

    /**
     * Create a new Redis instance.
     *
     * @param  Apt $apt
     * @return void
     */
    public function __construct(Apt $apt)
    {
        $this->apt = $apt;
    }

    /**
     * Install the configuration files for Redis.
     *
     * @return void
     */
    public function install()
    {
        if (! $this->apt->installed('redis-server')) {

            $this->apt->cli->quietly("LC_ALL=C.UTF-8 apt-add-repository ppa:chris-lea/redis-server -y");
            $this->apt->update();

            $this->apt->installQuietly('redis-server');

            $this->apt->cli->quietly("sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf");

            $this->restart();
        }
    }

    /**
     * Restart the Redis service.
     *
     * @return void
     */
    public function restart()
    {
        $this->apt->cli->quietly('service redis-serve restart');
    }

    public function uninstall()
    {
        $this->stop();
    }

    /**
     * Stop the Redis service.
     *
     * @return void
     */
    public function stop()
    {
        info('Stopping redis-server...');

        $this->apt->cli->quietly('service redis-server stop');
    }
}
