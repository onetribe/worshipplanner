<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

trait FlashesSuccessAndFailureTrait
{
    /**
     * Flashes a generic message depending on success or failure for updates
     *
     * @param Illuminate\Http\Request $request
     * @param bool $success
     * @return void
     **/
    public function flashUpdate(Request $request, bool $success)
    {
        if ($success) {
            $request->session()->flash('alert-success', trans('common.updated_successfully'));    
        } else {
            $request->session()->flash('alert-failure', trans('common.update_failed'));    
        }
    }

    /**
     * Flashes a generic message depending on success or failure for saves
     *
     * @param Illuminate\Http\Request $request
     * @param bool $success
     * @return void
     **/
    public function flashSave(Request $request, bool $success)
    {
        if ($success) {
            $request->session()->flash('alert-success', trans('common.saved_successfully'));    
        } else {
            $request->session()->flash('alert-failure', trans('common.save_failed'));    
        }
    }

    /**
     * Flashes a generic message depending on success or failure for deletions
     *
     * @param Illuminate\Http\Request $request
     * @param bool $success
     * @return void
     **/
    public function flashDelete(Request $request, bool $success)
    {
        if ($success) {
            $request->session()->flash('alert-success', trans('common.deleted_successfully'));    
        } else {
            $request->session()->flash('alert-failure', trans('common.delete_failed'));    
        }
    }

}