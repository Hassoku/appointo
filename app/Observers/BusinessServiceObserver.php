<?php

namespace App\Observers;

use App\Helper\SearchLog;
use App\BusinessService;

class BusinessServiceObserver
{
    public function created(BusinessService $service)
    {
        SearchLog::createSearchEntry($service->id, 'Service', $service->name, 'admin.business-services.edit');

    }

    public function updating(BusinessService $service)
    {
        SearchLog::updateSearchEntry($service->id, 'Service', $service->name, 'admin.business-services.edit');
    }

    public function deleted(BusinessService $service)
    {
        SearchLog::deleteSearchEntry($service->id, 'admin.business-services.edit');
    }
}
