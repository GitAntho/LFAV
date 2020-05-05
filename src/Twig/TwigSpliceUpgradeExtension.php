<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigSpliceUpgradeExtension extends AbstractExtension {
    
    public function getFilters(){
        return [new TwigFilter('etc', [$this, 'etcFilter'])];
    }

    public function etcFilter($content){
        $long = substr($content, 0, 70);
        $long = substr($long, 0, strrpos($long, ' ')) . '...';

        return $long;
    }
}