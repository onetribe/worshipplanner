<?php

namespace App\Http\Controllers;

use App\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'first_name',
        'last_name',
        'email',
        'current_password',
        'new_password',
    	'new_password_confirmation',
    ];

	/**
	 * @param App\Transformers\UserTransformer $userTransformer
	 * @return void
	 **/
	public function __construct(UserTransformer $userTransformer)
	{
		$this->middleware('auth');
		$this->model = new User;
		$this->transformer = $userTransformer;
	}


    /**
     * Display the specified User.
     *
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {

        return $this->apiShow($request, $user);
    }

    /**
     * Update the specified User.
     *
     * @param App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $rules = $this->getValidationRules();
        Validator::extend('password_match', function ($attribute, $value, $parameters, $validator) use ($user) {
            return app('hash')->check($value, $user->password);
        });
        $rules['current_password'] = 'password_match';

        $validator = $this->makeValidator($request, $rules);
        $data = $this->filterAndValidateInput($request, $validator);

        if (!empty($data['new_password'])) {
            $data['password'] = app('hash')->make($data['new_password']);    
        }

        $user->update($data);
        
        $meta = [
            'message' => trans('common.updated_successfully'),
        ];
        $out = $this->getItemAsArray($request, $user, $meta);

        return response()->json($out);
    }

        /**
     * Gets the validation rules from the model if it has default rules set
     *
     * @return array
     **/
    protected function getValidationRules()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'new_password' => 'required_with:current_password|confirmed|regex:' . config('security.password_policy'),
        ];
    }

}