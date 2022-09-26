<?php

namespace App\Controller;

use App\Entity\Photo;
use DateInterval;
use Imagick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class DefaultController extends AbstractController {

    const PHOTOS_PATH = __DIR__ . '/../../public/fotos';

    private CacheInterface $cache;

    public function __construct(CacheInterface $cache) {
        $this->cache = $cache;
    }

    public function index(): Response {
        /*
          $this->addFlash('primary', '<a href="#" class="alert-link">Primary</a> Teste 123');
          $this->addFlash('secondary', '<a href="#" class="alert-link">Secondary</a> Teste 123');
          $this->addFlash('success', '<a href="#" class="alert-link">Success</a> Teste 123');
          $this->addFlash('danger', '<a href="#" class="alert-link">Danger</a> Teste 123');
          $this->addFlash('warning', '<a href="#" class="alert-link">Warning</a> Teste 123');
          $this->addFlash('info', '<a href="#" class="alert-link">Info</a> Teste 123');
          $this->addFlash('light', '<a href="#" class="alert-link">Light</a> Teste 123');
          $this->addFlash('dark', '<a href="#" class="alert-link">Dark</a> Teste 123');
         */

        $photos = $this->cache->get('photos', function (ItemInterface $item) {           
            if ($item->isHit()) {
                return $item->get();
            }
            
            $photos = $this->scanPhotos();
            
            $item->expiresAfter(new DateInterval('P1Y'));
            $item->set($photos);
            
            return $photos;
        });
        
        $panoramas = "'" . implode("','", array_map(function($o) {return $o->getFileName();}, $photos)) . "'";

        return $this->render('default/index.html.twig', compact('photos','panoramas'));
    }

    private function scanPhotos() {

        $photos = [];
        
        $files = array_diff(scandir(self::PHOTOS_PATH), array('.', '..', 'thumb'));

        foreach ($files as $file) {
            $photo = new Photo();

            $photos[] = $photo->buildFromFile(self::PHOTOS_PATH . '/' . $file);

            if (!is_file(self::PHOTOS_PATH . '/thumb/' . $photo->getFileName())) {
                $this->generateThumbnail($photo);
            }
        }

        return $photos;
    }

    public function photos(): Response {
        $this->addFlash('notice', 'Teste 123');

        return $this->render('default/index.html.twig');
    }

    private function generateThumbnail(Photo $photo) {
        $file = self::PHOTOS_PATH . '/' . $photo->getFileName();
        $dest = self::PHOTOS_PATH . '/thumb/' . $photo->getFileName();

        if (is_file($file)) {
            $img = new Imagick($file);
            $img->setImageFormat('jpeg');
            $img->setImageCompression(Imagick::COMPRESSION_JPEG);
            $img->setImageCompressionQuality(80);
            $img->thumbnailImage(640, 320, false, false);
            file_put_contents($dest, $img);
        }
    }

}
