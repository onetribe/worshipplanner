<?php

namespace App\Http\ViewComposers;

use App\Repositories\SongRepository;
use App\Services\ActiveTeam;
use Illuminate\View\View;

class SongSelectComposer
{
    /**
     * The services repository implementation.
     *
     * @var App\Repostories\SongRepository
     */
    protected $songRepo;


    /**
     * @param App\Repostories\SongRepository $songRepo
     * @return void
     */
    public function __construct(SongRepository $songRepo)
    {
        $this->songRepo = $songRepo;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $songs = $this->songRepo->getAllOrdered(['authors']);

        $view->with('songs', $songs);
    }
}