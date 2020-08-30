<?php

namespace App;

use App\Entity\LinkCache;
use App\Services\Doctrine;
use App\Services\Scrapper;

class Main
{
    private string $link;

    public function __construct(string $link)
    {
        $this->link = $link;
    }

    public function __toString()
    {
        $this->removeOldCaches();
        dump($this->getLinkData());

        return '$scrapper->getLinkData()';
    }

    private function getLinkData(): LinkCache
    {
        $linkCache = Doctrine::getInst()->getEm()->getRepository(LinkCache::class)->findOneBy([
            'token' => md5($this->link)
        ]);
        if ($linkCache == null) {
            $scrapper  = new Scrapper($this->link);
            $linkCache = $scrapper->getLinkData();
            Doctrine::getInst()->getEm()->persist($linkCache);
            Doctrine::getInst()->getEm()->flush();
        }

        return $linkCache;
    }

    private function removeOldCaches()
    {
        $qb        = Doctrine::getInst()->getEm()->createQueryBuilder();
        $oldCaches = $qb
            ->from(LinkCache::class, 'lc')
            ->select('lc')
            ->where('lc.date < :date')
            ->setParameter('date', new \DateTime('-' . $_ENV['CACHE_AGE']))
            ->getQuery()
            ->getResult();

        foreach ($oldCaches as $oldCache) {
            Doctrine::getInst()->getEm()->remove($oldCache);
        }

        Doctrine::getInst()->getEm()->flush();
    }
}