<?php

namespace App\Filament\Resources\TreeResource\Pages;

use App\Filament\Resources\TreeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Tree;
use Filament\Resources\Components\Tab;

class ListTrees extends ListRecords
{
    protected static string $resource = TreeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected ?string $heading = 'Trees Section';

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            Tab::make('All')
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            Tab::make('Deceased')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('tree_status', Tree::DECEASED);
                }),
            Tab::make('Healthy')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('tree_status', Tree::HEALTHY);
                }),
            Tab::make('For Replacement')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('tree_status', Tree::FOR_REPLACEMENT);
                }),
        ];
    }
}
