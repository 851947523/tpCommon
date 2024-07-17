<?php

namespace Gz\TpCommon\lib\files\zips;
/**
 *  editor: gz,
 *  motto: 大自然的搬运工
 *  time: 2024/7/15
 */
trait Common
{

    public $zipArchive; //压缩文件类
    public $filePath;  //文件加路径

    /**
     *  解压文件到指定目录
     * @param $extractToPath 目标目录
     * @return void
     */
    public function decompressionZip(?string $extractToPath = ''): bool
    {
        $zip = $this->zipArchive;
        if ($zip->open($this->filePath) === TRUE) {
            // 解压所有文件到目标目录
            $zip->extractTo($extractToPath);
            // 关闭ZIP文件
            $zip->close();
            return true;
        } else {
            return false;
        }

    }

}