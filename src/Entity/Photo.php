<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\Table(name: 'photo')]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $fileName = null;

    #[ORM\Column(type: Types::DATETIME)]
    private ?DateTimeInterface $fileDateTime = null;

    #[ORM\Column]
    private ?int $fileSize = null;

    #[ORM\Column(length: 20)]
    private ?string $fileMimeType = null;

    #[ORM\Column]
    private ?int $fileWidth = null;

    #[ORM\Column]
    private ?int $fileHeight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ifd0ImageDescription = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ifd0Make = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ifd0Model = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ifd0Software = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $gpsLatitude = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $gpsLongitude = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $gpsAltitude = null;

    private function exifGpsCoordenate(array $value) : float
    {
        $val = explode("/", $value[0]);
        $degrees = $val[0] / $val[1];
        $val = explode("/", $value[1]);
        $minutes = $val[0] / $val[1];
        $val = explode("/", $value[2]);
        $seconds = $val[0] / $val[1];
                
        return floatval($degrees + ($minutes/60) + ($seconds/3600));
    }
    
    public function buildFromFile(string $pathFile) : self
    {
        if(file_exists($pathFile)) {
            $exif = exif_read_data($pathFile, 'ANY_TAG', true);
            
            $this->setFileName($exif['FILE']['FileName'])
                    ->setFileDateTime(new DateTime($exif['IFD0']['DateTime']), new \DateTimeZone('America/Sao_Paulo'))
                    ->setFileSize($exif['FILE']['FileSize'])
                    ->setFileMimeType($exif['FILE']['MimeType'])
                    ->setFileWidth($exif['COMPUTED']['Width'])
                    ->setFileHeight($exif['COMPUTED']['Height'])
                    ->setIfd0ImageDescription($exif['IFD0']['ImageDescription'])
                    ->setIfd0Make($exif['IFD0']['Make'])
                    ->setIfd0Model($exif['IFD0']['Model'])
                    ->setIfd0Software($exif['IFD0']['Software'])
                    ->setGpsLatitude((($exif['GPS']['GPSLatitudeRef'] == 'S')?'-':'') . $this->exifGpsCoordenate($exif['GPS']['GPSLatitude']))
                    ->setGpsLongitude((($exif['GPS']['GPSLongitudeRef'] == 'W')?'-':'') . $this->exifGpsCoordenate($exif['GPS']['GPSLongitude']))
                    ->setGpsAltitude(intval($exif['GPS']['GPSAltitude']));
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileDateTime(): ?DateTimeInterface
    {
        return $this->fileDateTime;
    }

    public function setFileDateTime(DateTimeInterface $fileDateTime): self
    {
        $this->fileDateTime = $fileDateTime;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileMimeType(): ?string
    {
        return $this->fileMimeType;
    }

    public function setFileMimeType(string $fileMimeType): self
    {
        $this->fileMimeType = $fileMimeType;

        return $this;
    }

    public function getFileWidth(): ?int
    {
        return $this->fileWidth;
    }

    public function setFileWidth(int $fileWidth): self
    {
        $this->fileWidth = $fileWidth;

        return $this;
    }

    public function getFileHeight(): ?int
    {
        return $this->fileHeight;
    }

    public function setFileHeight(int $fileHeight): self
    {
        $this->fileHeight = $fileHeight;

        return $this;
    }    
    
    public function getIfd0ImageDescription(): ?string
    {
        return $this->ifd0ImageDescription;
    }

    public function setIfd0ImageDescription(?string $ifd0ImageDescription): self
    {
        $this->ifd0ImageDescription = $ifd0ImageDescription;

        return $this;
    }

    public function getIfd0Make(): ?string
    {
        return $this->ifd0Make;
    }

    public function setIfd0Make(?string $ifd0Make): self
    {
        $this->ifd0Make = $ifd0Make;

        return $this;
    }

    public function getIfd0Model(): ?string
    {
        return $this->ifd0Model;
    }

    public function setIfd0Model(?string $ifd0Model): self
    {
        $this->ifd0Model = $ifd0Model;

        return $this;
    }

    public function getIfd0Software(): ?string
    {
        return $this->ifd0Software;
    }

    public function setIfd0Software(?string $ifd0Software): self
    {
        $this->ifd0Software = $ifd0Software;

        return $this;
    }

    public function getGpsLatitude(): ?string
    {
        return $this->gpsLatitude;
    }

    public function setGpsLatitude(?string $gpsLatitude): self
    {
        $this->gpsLatitude = $gpsLatitude;

        return $this;
    }

    public function getGpsLongitude(): ?string
    {
        return $this->gpsLongitude;
    }

    public function setGpsLongitude(?string $gpsLongitude): self
    {
        $this->gpsLongitude = $gpsLongitude;

        return $this;
    }

    public function getGpsAltitude(): ?string
    {
        return $this->gpsAltitude;
    }

    public function setGpsAltitude(?string $gpsAltitude): self
    {
        $this->gpsAltitude = $gpsAltitude;

        return $this;
    }
}
