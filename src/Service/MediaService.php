<?php

/**
 * MediaService File Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Service;

use Exception;
use App\Entity\Media;
use App\Entity\TypeMedia;
use App\Repository\MediaRepository;
use App\Repository\TypeMediaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * MediaService Class Doc Comment
 *
 * @category Service
 * @package  App\Service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 */
class MediaService
{
    /**
     * Summary of function __construct
     *
     * @param ParameterBagInterface $params              ParameterBagInterface
     * @param MediaRepository       $mediaRepository     MediaRepository
     * @param TypeMediaRepository   $typeMediaRepository TypeMediaRepository
     */
    public function __construct(
        private readonly ParameterBagInterface $params,
        private readonly MediaRepository       $mediaRepository,
        private readonly TypeMediaRepository   $typeMediaRepository
        ) {}

    /**
     * Summary of addNewImage
     *
     * @param UploadedFile $image     image
     * @param string       $folder    folder
     * @param int          $typeMedia typeMedia
     * 
     * @return Media
     */
    public function addNewImage(Object $image, string $folder, string $typeMedia): Media
    {
        $mediaImg = new Media();
        $mediaImg->setName($this->addImage($image, $folder));
        $mediaImg->setTypeMedia($this->getTypeMedia($typeMedia));
        return $mediaImg;
    }

    /**
     * Summary of addImage
     *
     * @param UploadedFile $image  image
     * @param string|null  $folder folder
     * @param int|null     $width  width
     * @param int|null     $height height
     * 
     * @return string
     */
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
            $imageWidth > $imageHeight => (($imageWidth - $squareSize) / 2),
        };

        $srcY = match(true){
            $imageWidth < $imageHeight => (($imageHeight - $squareSize) / 2),
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

    /**
     * Summary of deleteImage
     *
     * @param string      $file   file
     * @param string|null $folder folder
     * @param int|null    $width  width
     * @param int|null    $height height
     * 
     * @return bool
     */
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

    /**
     * Summary of removeMediaFromDb
     *
     * @param Media $media Media
     * 
     * @return void
     */
    public function removeMediaFromDb(Media $media): void
    {
        $this->mediaRepository->delete($media);
    }

    /**
     * Summary of addNewVideo
     *
     * @param string $video $video
     * 
     * @return Media
     */
    public function addNewVideo(string $video): Media
    {
        $mediaVid = new Media();
        $mediaVid->setName('https://www.youtube.com/embed/' . substr($video, 0, 11));
        $mediaVid->setTypeMedia($this->getTypeMedia('video'));
        $this->addVideo($mediaVid);
        return $mediaVid;
    }

    /**
     * Summary of getTypeMedia
     *
     * @param int $id id
     * 
     * @return TypeMedia
     */
    public function getTypeMedia(string $name): TypeMedia
    {
        return $this->typeMediaRepository->findOneByType($name);
    }

    /**
     * Summary of addVideo
     *
     * @param Media $video Media
     * 
     * @return void
     */
    public function addVideo(Media $video): void
    {
        $this->mediaRepository->save($video);
    }

    /**
     * Summary of deleteMedia
     *
     * @param Media $media Media
     * 
     * @return bool
     */
    public function deleteMedia(Media $media): bool
    {
        $typeMedia = $media->getTypeMedia()->getType();
        return match ($typeMedia) {
            'photo' => $this->deleteMediaImage($media, 'tricks'),
            'video' => $this->deleteMediaVideo($media),
            'avatar' => $this->deleteMediaImage($media, 'avatars'),
        };
    }

    /**
     * Summary of deleteMediaImage
     *
     * @param Media  $media  Media
     * @param string $folder $folder
     * 
     * @return bool
     */
    public function deleteMediaImage(Media $media, string $folder): bool
    {
        if($this->deleteImage($media->getName(), $folder, 300, 300)){
            $this->removeMediaFromDb($media);
            return true;
        }
        return false;
    }

    /**
     * Summary of deleteMediaVideo
     *
     * @param Media $media Media
     * 
     * @return bool
     */
    public function deleteMediaVideo(Media $media): bool
    {
        $this->removeMediaFromDb($media);
        return true;
    }

    public function getMedia(int $id): Media
    {
        return $this->mediaRepository->findOneById($id);
    }

    public function getMediaByName(string $name): Media
    {
        return $this->mediaRepository->findOneByName($name);
    }

}
