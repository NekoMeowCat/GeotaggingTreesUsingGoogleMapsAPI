<?php

namespace App\Filament\Resources\TreeResource\Pages;

use App\Filament\Resources\TreeResource;
use Filament\Resources\Pages\Page;
use App\Models\Tree;
use App\Models\Area;
use App\Models\Classification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

class TreeCreate extends Page implements HasForms
{
    use InteractsWithForms;

    public $tree_image;
    public $tree_name;
    public $tree_description;
    public $tree_status;
    public $tree_id;
    public $date_planted;
    public $beneficiary;
    public $latitude;
    public $longitude;
    public $area_id;
    public $classification_id;
    public $validated_at;

    protected static string $resource = TreeResource::class;

    protected static string $view = 'filament.resources.tree-resource.pages.tree-create';


    public function mount()
    {
        $this->form->fill([
            'tree_id' => $this->generateRandomTreeId(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->label('Latitude')
                                            ->required(),
                                        // ->reactive(),
                                        Forms\Components\TextInput::make('longitude')
                                            ->label('Longitude')
                                            ->required(),
                                        // ->reactive(),
                                        Forms\Components\TextInput::make('tree_name')
                                            ->label('Tree Name')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\Select::make('area_id')
                                            ->label('Area')
                                            ->options(function () {
                                                $areas = Area::all();
                                                $options = $areas->mapWithKeys(function ($area) {
                                                    return [$area->id => $area->name];
                                                });
                                                return $options;
                                            }),
                                        Forms\Components\Select::make('classification_id')
                                            ->label('Classfication')
                                            ->options(function () {
                                                $classification = Classification::all();
                                                $options = $classification->mapWithKeys(function ($classification) {
                                                    return [$classification->id => $classification->name];
                                                });
                                                return $options;
                                            }),
                                        Forms\Components\TextInput::make('beneficiary')
                                            ->required()
                                            ->maxLength(255),

                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('tree_status')
                                            ->label('Status')
                                            ->options([
                                                'Deceased' => 'Deceased',
                                                'Healthy' => 'Healthy',
                                                'For Replacement' => 'For Replacement',
                                            ]),
                                        Forms\Components\TextInput::make('tree_id')
                                            ->label('Tree Identification')
                                            ->readonly(),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\DatePicker::make('date_planted')
                                            ->label('Date Planted')
                                            ->required(),
                                        Forms\Components\DatePicker::make('validated_at')
                                            ->hiddenOn('create'),
                                        Forms\Components\Textarea::make('tree_description')
                                            ->label('Description')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                    ]),
                            ]),
                    ]),
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('tree_image')
                            ->label('Tree Image')
                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('3:1')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->preserveFilenames()
                            ->directory('images')
                            ->visibility('public')
                    ])
            ]);
    }

    public function generateRandomTreeId(): string
    {
        $lastTree = Tree::query()
            ->where('tree_id', 'like', 'A%')
            ->orderBy('tree_id', 'desc')
            ->first();

        if ($lastTree) {
            $lastNumber = intval(substr($lastTree->tree_id, 1));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'A' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function submit()
    {
        $formData = $this->form->getState();


        // dd($formData);

        Tree::create($formData);

        Notification::make()
            ->title('Tree has been added')
            ->success()
            ->send();

        $this->redirect(TreeResource::getUrl('index'));
    }
}
