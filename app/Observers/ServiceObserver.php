<?php

namespace App\Observers;

use App\Service;

class ServiceObserver
{
    use StripsTagsFromFields;

    /**
     * Listen to the Service saving event.
     *
     * @param App\Service $service
     * @return void
     */
    public function saving(Service $service)
    {
        $this->stripTags($service, ['title']);
    }
}