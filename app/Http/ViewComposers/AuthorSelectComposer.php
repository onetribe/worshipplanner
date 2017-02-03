<?php

namespace App\Http\ViewComposers;

use App\Repositories\AuthorRepository;
use App\Services\ActiveTeam;
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
     * @param App\Services\ActiveTeam $activeTeam
     * @return void
     */
    public function __construct(AuthorRepository $authors, ActiveTeam $activeTeam)
    {
        $this->authors = $authors;
        $this->activeTeam = $activeTeam;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $activeTeam = $this->activeTeam->get();
        $authors = $this->authors->getAllForTeam($activeTeam);

        $view->with('authors', $authors);
    }
}