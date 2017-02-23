<?php

namespace App\Http\Controllers;

use App\Author;
use App\Services\ActiveTeam;
use App\Transformers\AuthorTransformer;
use Illuminate\Http\Request;

class AuthorsController extends AbstractApiController
{

    /**
     * @var array
     **/
    protected $allowedInput = [
        'first_name',
        'middle_name',
        'last_name',
    ];

    /**
     * @param App\Transformers\AuthorTransformer $authorTransformer
     * @return void
     **/
    public function __construct(AuthorTransformer $authorTransformer)
    {
        $this->middleware('auth');
        $this->model = new Author;
        $this->transformer = $authorTransformer;
    }


    /**
     * Display the specified Author.
     *
     * @param App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Author $author)
    {
        return $this->apiShow($request, $author);
    }

    /**
     * Update the specified Author.
     *
     * @param App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        return $this->apiUpdate($request, $author);
    }

    /**
     * Delete the specified Author.
     *
     * @param App\Author $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Author $author)
    {
        return $this->apiDestroy($request, $author);
    }

    /**
     * Overrides the default base query as we need to make sure default authors and team authors are fetched
     *
     * @return Illuminate\Database\Eloquent\Builder
     **/
    public function getDefaultQuery()
    {
        return $this->model->newQuery()->where(function ($q) {
            $q->whereNull('team_id');
            $q->orWhere('team_id', app(ActiveTeam::class)->get()->id);
        });
    }
}