<?php

namespace App\Controller;

use App\Entity\Photo;
use Imagick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    const PHOTOS_PATH = __DIR__ . '/../../public/fotos';

    public function index(): Response
    {
        $this->addFlash('notice', 'Teste 123');
        
        $files = $this->scanFotos();
        
        $photos = [];
        $panoramas = [];
        
        foreach ($files as $file) {
            $photo = new Photo();
            
            $photos[] = $photo->buildFromFile(self::PHOTOS_PATH . '/' . $file);
            
            $panoramas[] = $photo->getFileName();
            
            if(!is_file(self::PHOTOS_PATH . '/thumb/' . $photo->getFileName())){
                $this->generateThumbnail($photo);
            }
        }
        
        $panoramas ="'" . implode("','", $panoramas) . "'";

        return $this->render('default/index.html.twig', compact('photos','panoramas'));
    }
    
    public function photos(): Response
    {
        $this->addFlash('notice', 'Teste 123');
        
        return $this->render('default/index.html.twig');
    }
    
    private function generateThumbnail(Photo $photo)
    {
        $file = self::PHOTOS_PATH . '/' . $photo->getFileName();
        $dest = self::PHOTOS_PATH . '/thumb/' . $photo->getFileName();
        
        if(is_file($file)){
            $img = new Imagick($file);
            $img->setImageFormat('jpeg');
            $img->setImageCompression(Imagick::COMPRESSION_JPEG);
            $img->setImageCompressionQuality(80);
            $img->thumbnailImage(640, 320, false, false);
            file_put_contents($dest, $img);
        }
    }
    
    /**
     * 
     * @return array
     */
    private function scanFotos()
    {
        $fotos = array_diff(scandir(self::PHOTOS_PATH), array('.','..', 'thumb'));
        return $fotos;
    }
}
