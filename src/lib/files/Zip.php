<?php

namespace Gz\TpCommon\lib\files;

use Gz\TpCommon\lib\files\interfaces\UploadInterface;
use Gz\TpCommon\lib\files\types\Local;
use Gz\TpCommon\lib\files\types\Qny;
use Gz\TpCommon\lib\files\zips\Common;
use Gz\Utools\Instance\Instance;

/**
 * @mixin Local;
 * @mixin Qny;
 */
class Zip
{
    use Instance;
    use Common;

    public function init($filePath)
    {
        $this->filePath = $filePath;
        //判断扩展是否存在
        if (!class_exists('ZipArchive')) throw new \Exception('ZipArchive');
        $this->zipArchive = new \ZipArchive($filePath);
        return $this;
    }


}