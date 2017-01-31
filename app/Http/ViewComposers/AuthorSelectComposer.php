<?php

namespace App\Http\ViewComposers;

use App\Repositories\AuthorRepository;
use Illuminate\View\View;

class AuthorSelectComposer
{
    /**
     * The services repository implementation.
     *
     * @var App\Repostories\AuthorRepository
     */
    protected $authors;


    /**
     * @param App\Repostories\AuthorRepository $authors
     * @return void
     */
    public function __construct(AuthorRepository $authors)
    {
        $this->authors = $authors;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $authors = $this->authors
            ->orderBy('last_name', 'ASC')
            ->orderBy('first_name', 'ASC')
            ->orderBy('middle_name', 'ASC')
            ->get();

        $view->with('authors', $authors);
    }
}