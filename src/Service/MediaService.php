<?php

namespace App\Service;

use Exception;
use App\Entity\Media;
use App\Entity\TypeMedia;
use App\Repository\MediaRepository;
use App\Repository\TypeMediaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MediaService
{
    public function __construct(
        private readonly ParameterBagInterface $params,
        private readonly MediaRepository $mediaRepository,
        private readonly TypeMediaRepository $typeMediaRepository
        ) {}

    public function addImage(UploadedFile $image, ?string $folder = '', ?int $width = 300, ?int $height = 300): string
    {
        $file = md5(uniqid(rand(), true)) . '.webp';
        $imageInfos = getimagesize($image);
        if ($imageInfos === false){
            throw new Exception('Format d\'image incorrect');
        }

        $imageSource = match($imageInfos['mime']){
            'image/png' => imagecreatefrompng($image),
            'image/jpeg' => imagecreatefromjpeg($image),
            'image/webp' => imagecreatefromwebp($image),
            default => throw new Exception('Format d\'image incorrect'),
        };

        $imageWidth = $imageInfos[0];
        $imageHeight = $imageInfos[1];

        $squareSize = match(true){
            $imageWidth <= $imageHeight => $imageWidth,
            $imageWidth > $imageHeight => $imageHeight,
        };

        $srcX = match(true){
            $imageWidth <= $imageHeight => 0,
            $imageWidth > $imageHeight => ($imageWidth - $squareSize) / 2,
        };

        $srcY = match(true){
            $imageWidth < $imageHeight => ($imageHeight - $squareSize) / 2,
            $imageWidth >= $imageHeight => 0,
        };

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

    public function deleteImage(string $file, ?string $folder = '', ?int $width = 300, ?int $height = 300): bool
    {
        $success = false;

        if($file !== 'photo_default.jpg'){
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
        }
        return $success;
    }

    public function removeImageFromDb(Media $media): void
    {
        $this->mediaRepository->delete($media);
    }

    public function getTypeMedia(int $id): TypeMedia
    {
        return $this->typeMediaRepository->findOneById($id);
    }

    public function addVideo(Media $video): void
    {
        $this->mediaRepository->save($video);
    }

}
