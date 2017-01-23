<?php
namespace Planet\Agent\Helper\File;


use PHPExcel_IOFactory;

abstract class AbstractFile
{
    protected $file;

    protected $worksheet;

    public function load($file)
    {
        $this->file = $file;

        $objPHPExcel = PHPExcel_IOFactory::load($file);
        $this->worksheet = $objPHPExcel->getActiveSheet();
    }

    protected function getCell($coordinate)
    {
        return trim($this->worksheet->getCell($coordinate));
    }

}