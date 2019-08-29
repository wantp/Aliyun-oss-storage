<?php
/**
 * Created by jacob.
 * User: jacob
 * Date: 16/5/20
 * Time: 下午8:31
 */

namespace Jacobcyl\AliOSS\Plugins;

use League\Flysystem\Config;
use League\Flysystem\Plugin\AbstractPlugin;
use OSS\OssClient;

class GetDownloadUrl extends AbstractPlugin
{
    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethod()
    {
        return 'downloadUrl';
    }

    public function handle($path, $timeout = 60)
    {
        $options = ['response-content-type' => 'application/octet-stream'];
        $url     = $this->filesystem->getAdapter()->getSignUrl($path, $timeout, OssClient::OSS_HTTP_GET, $options);

        return $url;
    }
}
