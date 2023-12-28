<?php

namespace App\Service;

use Exception;
use App\Entity\Media;
use App\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MediaService
{
    public function __construct(private ParameterBagInterface $params, private readonly MediaRepository $mediaRepository) {}

    public function add(UploadedFile $image, ?string $folder = '', ?int $width = 300, ?int $height = 300)
    {
        $file = md5(uniqid(rand(), true)) . '.webp';
        $imageInfos = getimagesize($image);
        if ($imageInfos === false){
            throw new Exception('Format d\'image incorrect');
        }

        switch($imageInfos['mime']){
            case 'image/png':
                $imageSource = imagecreatefrompng($image);
                break;
            case 'image/jpeg':
                $imageSource = imagecreatefromjpeg($image);
                break;
            case 'image/webp':
                $imageSource = imagecreatefromwebp($image);
                break;           
            default:
                throw new Exception('Format d\'image incorrect');
        }

        $imageWidth = $imageInfos[0];
        $imageHeight = $imageInfos[1];

        switch($imageWidth <=> $imageHeight){
            case -1: //portrait
                $squareSize = $imageWidth;
                $srcX = 0;
                $srcY = ($imageHeight - $squareSize) / 2;
                break;           
            case 0: //carré
                $squareSize = $imageWidth;
                $srcX = 0;
                $srcY = 0;
                break;           
            case 1: //paysage
                $squareSize = $imageHeight;
                $srcX = ($imageWidth - $squareSize) / 2;
                $srcY = 0;
                break;           
        }

        $resizedImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizedImage, $imageSource, 0, 0, $srcX, $srcY, $width, $height, $squareSize, $squareSize);

        $path = $this->params->get('images_directory') . $folder;

        if(!file_exists($path . '/mini/')){
            mkdir($path . '/mini/', 0755, true);
        }

        imagewebp($resizedImage, $path . '/mini/' . $width . 'x' . $height . '-' . $file);

        $image->move($path . '/', $file);

        return $file;
    }

    public function delete(string $file, ?string $folder = '', ?int $width = 300, ?int $height = 300)
    {
        if($file !== 'photo_default.jpg'){
            $success = false;
            $path = $this->params->get('images_directory') . $folder;

            $mini = $path . '/mini/' . $width . 'x' . $height . '-' . $file;

            if(file_exists($mini)){
                unlink($mini);
                $success = true;
            }

            $original = $path . '/' . $file;

            if(file_exists($original)){
                unlink($original);
                $success = true;
            }
            return $success;
        }
    }

    public function removeFromDb(Media $media): void
    {
        $this->mediaRepository->delete($media);
    }

}
