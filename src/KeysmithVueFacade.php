<?php

namespace Blaspsoft\KeysmithVue;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Blaspsoft\KeysmithVue\Skeleton\SkeletonClass
 */
class KeysmithVueFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'keysmith-vue';
    }
}
