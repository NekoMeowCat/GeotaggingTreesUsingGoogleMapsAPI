<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.events.view-event';

    protected ?string $heading = ' ';

    protected static ?string $title = 'Events';

    // Override getBreadcrumb method and make it public
    public function getBreadcrumb(): string
    {
        return $this->record->event_title ?? 'Event';
    }
}
