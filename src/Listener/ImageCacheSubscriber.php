<?php

namespace App\Listener;

use App\Entity\Property;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class ImageCacheSubscriber implements EventSubscriber
{

    public function __construct(CacheManager $cachemanager, UploaderHelper $uploaderHelper)
    {
        $this->cachemanager = $cachemanager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'preUpdate'
        ];
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Property) {
            return;
        }
        $this->cachemanager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Property) {
            return;
        }

        if ($entity->getImageFile() instanceof UploadedFile) {
            $this->cachemanager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
        }
    }
}
