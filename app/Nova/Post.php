<?php

namespace App\Nova;

use App\Nova\Actions\ChangeActiveStatus;
use App\Nova\Filters\ActiveStatus;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\PostsByActiveType;
use App\Nova\Metrics\PostsPerDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Post extends TotalCountsResource
{
    public static $indexDefaultOrder = ['name' => 'desc'];

    public static function icon()
    {
        return '<i class="far fa-edit"></i>';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'details';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'description'
    ];

    // show in side bar
    public static $displayInNavigation = true;

    // put in group in side bar
    public static $group = "Other";

    // make resource data searchable or not
    public static $globallySearchable = true;

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
            Text::make('Name', 'name')
            ->rules('required'),
            Textarea::make('Description', 'description'),
            // ->showOnIndex(),
            // ->alwaysShow(),
            // ->placeholder('My New Post'),


            Date::make('Published Date', 'date_published')
            ->rules('required', function ($attribute, $value, $fail) {
                if (Carbon::createFromFormat('Y-m-d', $value)->isPast()) {
                    return $fail('Plaese only feature dates!');
                }
            }),

            // Image::make('Image'),

            BelongsToMany::make('Tags'),

            MorphMany::make('Reviews'),

            BelongsTo::make('User'),

            Boolean::make('Active?', 'is_active'),
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
        return [
            new NewUsers(),
            new PostsPerDay(),
            new PostsByActiveType(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new ActiveStatus()
        ];
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
        return [
            (new ChangeActiveStatus())->showOnTableRow()

        ];
    }
}
