<?php
/**
 * Created by PhpStorm.
 * User: tiago
 * Date: 30/11/2018
 * Time: 15:09
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function removeFile(String $fileName)
    {
        $filePath = $this->getTargetDirectory() . '/' . $fileName;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        return $this;
    }
}