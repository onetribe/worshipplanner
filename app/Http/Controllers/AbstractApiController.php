<?php

namespace App\Http\Controllers;

use App\HasValidationRulesTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item as FractalItem;
use League\Fractal\Scope;
use League\Fractal\Serializer\DataArraySerializer;

abstract class AbstractApiController extends Controller
{
    /**
     * @var Illuminate\Database\Eloquent\Model
     **/
    protected $model;

    /**
     * @var App\Transformers\TransformerInterface
     **/
    protected $transformer;

    /**
     * @var array
     **/
    protected $allowedInput = [];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request) : JsonResponse
    {
        $items = $this->getItemsAsArray($request);

        return response()->json($items);
    }

    /**
     * Display the specified resource.
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow(Request $request, Model $model) : JsonResponse
    {
        $item = $this->getItemAsArray($request, $model);

        return response()->json($item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $data = $this->filterAndValidateInput($request);

        $newModel = $this->model->newInstance($data);
        $newModel->save();

        $meta = [
            'message' => trans('common.saved_successfully'),
        ];
        $out = $this->getItemAsArray($request, $newModel, $meta);

        return response()->json($out);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, Model $model) : JsonResponse
    {
        $validationRulesToUse = array_intersect_key($this->getValidationRules(), $request->all());

        $data = $this->filterAndValidateInput($request, $validationRulesToUse);

        $model->update($data);
        
        $meta = [
            'message' => trans('common.updated_successfully'),
        ];
        $out = $this->getItemAsArray($request, $model, $meta);

        return response()->json($out);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Http\Response
     */
    public function apiDestroy(Request $request, Model $model) : JsonResponse
    {
        $model->delete();

        $data = [
            'meta' => [
                'message' => trans('common.deleted_successfully'),
            ],
        ];

        return response()->json($data);
    }

    /**
     * Get items for this request as JSON string output
     *
     * @param Request $request
     * @param array $meta
     * @return string
     **/
    protected function getItemsAsJson(Request $request, $meta = []) : string
    {
        return $this->getItems($request, $meta)->toJson();
    }

    /**
     * Get items for this request as array output
     *
     * @param Request $request
     * @param array $meta
     * @return array
     **/
    protected function getItemsAsArray(Request $request, $meta = []) : array
    {
        return $this->getItems($request, $meta)->toArray();
    }

    /**
     * Get item for this request as JSON string output
     *
     * @param Request $request
     * @param  Illuminate\Database\Eloquent\Model $model
     * @param array $meta
     * @return string
     **/
    protected function getItemAsJson(Request $request, $model, $meta = []) : string
    {
        return $this->getItem($request, $model, $meta)->toJson();
    }

    /**
     * Get items for this request as array output
     *
     * @param Request $request
     * @param  Illuminate\Database\Eloquent\Model $model
     * @param array $meta
     * @return array
     **/
    protected function getItemAsArray(Request $request, $model, $meta = []) : array
    {
        return $this->getItem($request, $model, $meta)->toArray();
    }

    /**
     * Retrieves the given items by id's, if the array is empty, retrieve all.
     * Returns a JSON array of items.
     *
     * @param Request $request
     * @param  array $meta
     * @return League\Fractal\Scope
     **/
    protected function getItems(Request $request, array $meta = []) : Scope
    {
        $fields = $request->input('fields', ['*']);
        $ids = $request->input('ids', ['*']);
        $ids = is_string($ids) ? explode(",", $ids) : $ids;
        $page = $request->input('page', null); //by default we will return all models
        $perPage = $request->input('perPage', config('api.perPageDefault'));
        
        $manager = $this->getFractalManager($request);

        $items = $this->getDefaultQuery()
            ->multiForApi($ids, $page, $perPage)
            ->get($fields);

        $resource = $this->getFractalResource($items, $manager);
        $meta = array_merge([
            'page' => $page ?: "all",
            'perPage' => $page ? $perPage : "all",
        ], $meta);

        $resource->setMeta($meta);

        return $manager->createData($resource);
    }

    /**
     * Return the default base query to use when fetching items
     *
     * @return Illuminate\Database\Eloquent\Builder
     **/
    public function getDefaultQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * Get the given item as a fractal scope, which can be turned into array or json
     *
     * @param Illuminate\Http\Request $request
     * @param Illuminate\Database\Eloquent\Model $model
     * @param  array $meta
     * @return League\Fractal\Scope
     **/
    protected function getItem(Request $request, $model, array $meta = [])
    {
        $manager = $this->getFractalManager($request);

        $resource = $this->getFractalResource($model, $manager);
        $resource->setMeta($meta);

        return $manager->createData($resource);
    }

    /**
     * Gets the fractal resource for the given items | item
     *
     * @param Illuminate\Database\Eloquent\Collection | Illuminate\Database\Eloquent\model $itemOrItems
     * @param League\Fractal\Manager $manager
     * @return League\Fractal\Resource\ResourceAbstract
     **/
    protected function getFractalResource($itemOrItems, Manager $manager)
    {
        $includes = $manager->getRequestedIncludes();

        if (count($includes) > 0) {
            $itemOrItems->load($includes);
        }

        return $itemOrItems instanceof Model
            ? new FractalItem($itemOrItems, $this->getTransformer())
            : new FractalCollection($itemOrItems, $this->getTransformer());
    }

    /**
     * Returns a new fractal Manager instance
     *
     * @return League\Fractal\Manager
     **/
    protected function getFractalManager(Request $request)
    {
        $manager = new Manager;
        $manager->setSerializer(new DataArraySerializer());
        $manager->parseIncludes($request->input('include', []));

        return $manager;
    }
    /**
     * Returns the transformer for this resource
     *
     * @return App\Transformers\TransformerInterface | \Callable
     **/
    protected function getTransformer()
    {
        return $this->transformer ?: function($model) {
            return $model->toArray();
        };
    }
    
    /**
     * Filters input data for creating/updating models. only fields in $allowedInput
     * will be used.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $rules
     * @return array
     **/
    protected function filterAndValidateInput(Request $request, Validator $validator = null)
    {
        $data = $request->intersect($this->allowedInput);

        if (!is_null($validator)) {
            $this->validateWith($validator, $request);
        } else {
            $validationRules = $this->getValidationRules();
            $this->validate($request, $validationRules);    
        }

        return $data;
    }

    /**
     * Gets the validation rules from the model if it has default rules set
     *
     * @return array
     **/
    protected function getValidationRules()
    {
        return method_exists($this->model, "getValidationRules")
         ? $this->model->getValidationRules()
         : [];
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return Illuminate\Validation\Validator
     */
    protected function makeValidator(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        return $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
    }
}
