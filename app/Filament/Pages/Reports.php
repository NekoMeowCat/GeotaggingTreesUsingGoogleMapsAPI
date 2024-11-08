<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Tree;

class Reports extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.reports';

    public $treeData;

    public function mount()
    {
        $this->loadTreeData();
    }

    protected function loadTreeData()
    {
        // Load tree data with related area and classification information
        $this->treeData = Tree::with(['area', 'classification'])
            ->orderBy('date_planted', 'desc') // Example ordering
            ->get();
    }
}
