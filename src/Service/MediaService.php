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

    public function addNewImage(Object $image, string $folder, int $typeMedia):Media
    {
        $mediaImg = new Media();
        $mediaImg->setName($this->addImage($image, $folder));
        $mediaImg->setTypeMedia($this->getTypeMedia($typeMedia));
        return $mediaImg;
    }

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

    public function removeMediaFromDb(Media $media): void
    {
        $this->mediaRepository->delete($media);
    }

    public function addNewVideo(string $video): Media
    {
        $mediaVid = new Media();
        $mediaVid->setName('https://www.youtube.com/embed/' . substr($video, 0, 11));
        $mediaVid->setTypeMedia($this->getTypeMedia(2));
        $this->addVideo($mediaVid);
        return $mediaVid;
    }

    public function getTypeMedia(int $id): TypeMedia
    {
        return $this->typeMediaRepository->findOneById($id);
    }

    public function addVideo(Media $video): void
    {
        $this->mediaRepository->save($video);
    }

    public function deleteMedia(Media $media): bool
    {
        $typeMedia = $media->getTypeMedia()->getId();
        return match ($typeMedia) {
            1 => $this->deleteMediaImage($media, 'tricks'),
            2 => $this->deleteMediaVideo($media),
            3 => $this->deleteMediaImage($media, 'avatars'),
        };
    }

    public function deleteMediaImage(Media $media, string $folder): bool
    {
        if($this->deleteImage($media->getName(), $folder, 300, 300)){
            $this->removeMediaFromDb($media);
            return true;
        }
        return false;
    }

    public function deleteMediaVideo(Media $media): bool
    {
        $this->removeMediaFromDb($media);
        return true;
    }

    public function getMedia(int $id): Media
    {
        return $this->mediaRepository->findOneById($id);
    }

}
