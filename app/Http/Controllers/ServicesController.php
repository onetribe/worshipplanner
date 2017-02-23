<?php

namespace App\Http\Controllers;

use App\Service;
use App\Transformers\BasicTransformer;
use Illuminate\Http\Request;

class ServicesController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'title',
    ];

    /**
     * @param App\Transformers\BasicTransformer $bandTransformer
     * @return void
     **/
    public function __construct(BasicTransformer $bandTransformer)
    {
        $this->middleware('auth');
        $this->model = new Service;
        $this->transformer = $bandTransformer;
    }


    /**
     * Display the specified Service.
     *
     * @param App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Service $service)
    {
        return $this->apiShow($request, $service);
    }

    /**
     * Update the specified Service.
     *
     * @param App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        return $this->apiUpdate($request, $service);
    }

    /**
     * Delete the specified Service.
     *
     * @param App\Service $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        return $this->apiDestroy($request, $service);
    }
}