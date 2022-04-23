<?php

namespace App\View\Components;

use Illuminate\View\View;
use App\Models\Cost;
use App\Models\Format;
use Illuminate\View\Component;
use Session;

class PreviewModal extends Component
{
    public $costs;
    public $formats;
 
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->costs = Cost::where('sessionID', Session::getId())->get();
        $this->formats = Format::where('sessionID', Session::getId())->get();
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.previewModal');
    }

}