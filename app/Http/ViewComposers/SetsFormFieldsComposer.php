<?php

namespace App\Http\ViewComposers;

use App\Repositories\ServicesRepository;
use App\Services\DateHelperInterface;
use Carbon\Carbon;
use Illuminate\View\View;

class SetsFormFieldsComposer
{
    /**
     * The services repository implementation.
     *
     * @var App\Repostories\ServicesRepository
     */
    protected $services;

    /**
     * @var App\Services\DateHelperInterface
     */
    protected $dateHelper;

    /**
     * Create a new profile composer.
     *
     * @param  ServicesRepository  $services
     * @return void
     */
    public function __construct(ServicesRepository $services, DateHelperInterface $dateHelper)
    {
        $this->services = $services;
        $this->dateHelper = $dateHelper;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $nextSunday = $this->dateHelper->userDateTime(new Carbon("next Sunday"));
        $services = $this->services->all();
        $firstServiceTitle = $services->first() 
            ? $nextSunday->format("Y-m-d") . " " . $services->first()->title
            : $nextSunday->format("Y-m-d");

        $view->with('services', $services)
             ->with('nextSunday', $nextSunday)
             ->with('firstServiceTitle', $firstServiceTitle);
    }
}