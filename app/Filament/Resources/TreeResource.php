<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TreeResource\Pages;
use App\Filament\Resources\TreeResource\RelationManagers;
use App\Models\Tree;
use App\Models\Area;
use App\Models\Classification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Imports\TreeImporter;




class TreeResource extends Resource
{
    protected static ?string $model = Tree::class;

    protected static ?string $navigationIcon = 'heroicon-s-puzzle-piece';

    protected static ?string $navigationGroup = 'Tree Entry';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        FileUpload::make('tree_image')
                            ->label('Tree Image')
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('3:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                        // ->disk('public')
                        // ->directory('images'),
                    ]),
                Section::make()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('tree_name')
                                            ->label('Tree Name')
                                            ->required()
                                            ->maxLength(255),
                                        // Inside the TreeResource form method
                                        Select::make('area_id')
                                            ->label('Area')
                                            ->options(function () {
                                                // Fetch all areas from the database
                                                $areas = Area::all();

                                                // Convert each area to an option array
                                                $options = $areas->mapWithKeys(function ($area) {
                                                    return [$area->id => $area->name]; // Assuming 'name' is the attribute you want to display
                                                });

                                                // Return the options array
                                                return $options;
                                            }),
                                        Select::make('classification_id')
                                            ->label('Classification')
                                            ->options(function () {
                                                // Fetch all areas from the database
                                                $classification = Classification::all();

                                                // Convert each area to an option array
                                                $options = $classification->mapWithKeys(function ($classification) {
                                                    return [$classification->id => $classification->name]; // Assuming 'name' is the attribute you want to display
                                                });

                                                // Return the options array
                                                return $options;
                                            }),
                                        Forms\Components\TextInput::make('tree_description')
                                            ->label('Description')
                                            ->label('Tree Description')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Grid::make()
                                    ->schema([
                                        Select::make('tree_status')
                                            ->label('Status')
                                            ->options([
                                                'Diseased' => 'Diseased',
                                                'Healthy' => 'Healthy',
                                                'For Replacement' => 'For Replacement'
                                            ]),
                                        Forms\Components\TextInput::make('tree_id')
                                            ->label('Tree ID')
                                            ->default(TreeResource::generateRandomTreeId())
                                            ->readonly(),
                                    ]),
                                Grid::make()
                                    ->schema([
                                        Forms\Components\DatePicker::make('date_planted')
                                            ->required(),
                                        Forms\Components\DatePicker::make('validated_at')
                                            ->hiddenOn('create'),
                                        Forms\Components\TextInput::make('latitude')
                                            ->required()
                                            ->numeric(),
                                        Forms\Components\TextInput::make('longitude')
                                            ->required()
                                            ->numeric(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(TreeImporter::class)
                    ->color('success')
            ])
            ->columns([
                Tables\Columns\ImageColumn::make('tree_image')
                    ->circular(),
                Tables\Columns\TextColumn::make('tree_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('area.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('classification.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tree_status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'danger' => 'Diseased',
                        'success' => 'Healthy',
                        'warning' => 'For Replacement',
                    ])
                    ->searchable(),
                Tables\Columns\TextColumn::make('tree_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_planted')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('validated_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }



    public static function generateRandomTreeId(): string
    {
        $lastTree = static::$model::query()
            ->where('tree_id', 'like', 'A%')
            ->orderBy('tree_id', 'desc')
            ->first();

        if ($lastTree) {

            $lastNumber = intval(substr($lastTree->tree_id, 1));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $nextTreeId = 'A' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return $nextTreeId;
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrees::route('/'),
            'create' => Pages\TreeCreate::route('/create'),
            'edit' => Pages\EditTree::route('/{record}/edit'),
        ];
    }
}
