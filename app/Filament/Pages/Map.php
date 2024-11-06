<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Tree;
use App\Models\Area;
use Illuminate\Contracts\View\View;

class Map extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-globe-asia-australia';

    protected static ?string $navigationGroup = 'Monitoring';

    // protected ?string $heading = ' ';

    protected static string $view = 'filament.pages.map';

    public $trees;


    public function mount()
    {
        $this->trees = Tree::with(['area', 'classification'])->get(); // Eager load the Area and Classification models
    }
}
