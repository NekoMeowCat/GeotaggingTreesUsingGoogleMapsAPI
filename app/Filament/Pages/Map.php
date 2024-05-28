<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Tree;
use App\Models\Area;
use Illuminate\Contracts\View\View;

class Map extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.map';

    public $trees;

    public function mount()
    {
        $this->trees = Tree::with(['area', 'classification'])->get(); // Eager load the Area and Classification models
    }

}
