<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Timezone;
use Laravel\Nova\Http\Requests\NovaRequest;

class Address extends Resource
{

    public static function icon()
    {
        return '<i class="fas fa-map-marker-alt"></i>';
    }

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Address::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'country';
    public static $group = 'Users';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        "address_line_1",
        "address_line_2",
        "city",
        "state",
        "country",
        "postal_code",
        "timezone",
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            $this->addressFields(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return \Illuminate\Http\Resources\MergeValue
     */
    protected function addressFields()
    {
        return $this->merge([
            BelongsTo::make('User'),
            Place::make('Address', 'address_line_1')
                ->sortable(),
            Text::make('Address Line 2')->hideFromIndex(),
            Text::make('City')
                ->sortable(),

            Text::make('State')
                ->sortable(),

            Text::make('Postal Code')->hideFromIndex()
                ->sortable(),

            Timezone::make('Timezone')->hideFromIndex()
                ->sortable(),

            Country::make('Country')
                ->sortable(),
        ]);
    }
}
