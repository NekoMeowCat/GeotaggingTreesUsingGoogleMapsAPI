<?php

namespace App\Filament\Imports;

use App\Models\Tree;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Carbon\Carbon;


class TreeImporter extends Importer
{
    protected static ?string $model = Tree::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('tree_name')
                ->requiredMapping(),
            // ->rules(['required', 'max:255']),
            ImportColumn::make('tree_description')
                ->requiredMapping(),
            // ->rules(['required', 'max:255']),
            ImportColumn::make('area')
                ->requiredMapping()
                // ->numeric()
                ->relationship(resolveUsing: ['name', 'description']),
            // ->rules(['required', 'integer']),
            ImportColumn::make('classification')
                ->requiredMapping()
                // ->numeric()
                ->relationship(resolveUsing: ['name', 'description']),
            // ->rules(['required', 'integer']),
            ImportColumn::make('tree_status')
                ->requiredMapping(),
            // ->rules(['required', 'max:255']),
            ImportColumn::make('tree_image'),
            // ->rules(['max:255']),
            ImportColumn::make('tree_id')
                ->requiredMapping(),
            // ->rules(['required', 'max:255']),
            ImportColumn::make('date_planted')
                ->requiredMapping()
                ->castStateUsing(function (string $state): ?string {
                    if (blank($state)) {
                        return null;
                    }
                    // Attempt to convert 'd-M-y' format to 'Y-m-d'
                    try {
                        return Carbon::createFromFormat('d-M-y', $state)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Handle the error as necessary, or return null
                        return null; // Or throw an exception to stop the import
                    }
                }),
            // ->rules(['required', 'date']),
            ImportColumn::make('latitude')
                ->requiredMapping()
                ->numeric(),
            // ->rules(['required', 'integer']),
            ImportColumn::make('longitude')
                ->requiredMapping()
                ->numeric(),
            // ->rules(['required', 'integer']),
            ImportColumn::make('validated_at')
                ->castStateUsing(function (string $state): ?string {
                    if (blank($state)) {
                        return null;
                    }

                    // Attempt to convert 'd-M-y' format to 'Y-m-d'
                    try {
                        return Carbon::createFromFormat('d-M-y', $state)->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Handle the error as necessary, or return null
                        return null; // Or throw an exception to stop the import
                    }
                }),
            // ->rules(['date']),
        ];
    }

    public function resolveRecord(): ?Tree
    {
        // return Tree::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Tree();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your tree import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
