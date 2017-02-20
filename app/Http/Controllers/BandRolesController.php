<?php

namespace App\Http\Controllers;

use App\BandRole;
use App\Transformers\BasicTransformer;
use Illuminate\Http\Request;

class BandRolesController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
    	'title',
    ];

	/**
	 * @param App\Transformers\BasicTransformer $bandRoleTransformer
	 * @return void
	 **/
	public function __construct(BasicTransformer $bandRoleTransformer)
	{
		$this->middleware('auth');
		$this->model = new BandRole;
		$this->transformer = $bandRoleTransformer;
	}


    /**
     * Display the specified BandRole.
     *
     * @param App\BandRole $bandRole
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, BandRole $bandRole)
    {
        return $this->apiShow($request, $bandRole);
    }

    /**
     * Update the specified BandRole.
     *
     * @param App\BandRole $bandRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BandRole $bandRole)
    {
        return $this->apiUpdate($request, $bandRole);
    }

    /**
     * Delete the specified BandRole.
     *
     * @param App\BandRole $bandRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BandRole $bandRole)
    {
        return $this->apiDestroy($request, $bandRole);
    }
}