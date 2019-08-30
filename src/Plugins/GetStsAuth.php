<?php
/**
 * Created by jacob.
 * User: jacob
 * Date: 16/5/20
 * Time: 下午8:31
 */

namespace Jacobcyl\AliOSS\Plugins;

use League\Flysystem\Plugin\AbstractPlugin;

class GetStsAuth extends AbstractPlugin
{
    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'stsAuth';
    }

    public function handle()
    {
        return $this->filesystem->getAdapter()->stsAuth();
    }
}
