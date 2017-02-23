<?php

namespace App\Http\Controllers;

use App\Band;
use App\Transformers\BandTransformer;
use Illuminate\Http\Request;

class BandsController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'title',
    ];

    /**
     * @param App\Transformers\BandTransformer $bandTransformer
     * @return void
     **/
    public function __construct(BandTransformer $bandTransformer)
    {
        $this->middleware('auth');
        $this->model = new Band;
        $this->transformer = $bandTransformer;
    }


    /**
     * Display the specified Band.
     *
     * @param App\Band $band
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Band $band)
    {
        return $this->apiShow($request, $band);
    }

    /**
     * Update the specified Band.
     *
     * @param App\Band $band
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Band $band)
    {
        return $this->apiUpdate($request, $band);
    }

    /**
     * Delete the specified Band.
     *
     * @param App\Band $band
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Band $band)
    {
        return $this->apiDestroy($request, $band);
    }
}