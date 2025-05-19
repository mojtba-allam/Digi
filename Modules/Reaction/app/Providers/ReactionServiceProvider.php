<?php

namespace Modules\Reaction\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Reaction\app\Repositories\ReviewRepositoryInterface;
use Modules\Reaction\app\Repositories\EloquentReviewRepository;

class ReactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ReviewRepositoryInterface::class,
            EloquentReviewRepository::class
        );
        $this->app->bind(
            \Modules\Reaction\app\Repositories\RatingRepositoryInterface::class,
            \Modules\Reaction\app\Repositories\EloquentRatingRepository::class
        );
    }

    public function boot(): void
    {
        // make __('reaction::messages.key') work
        $this->loadTranslationsFrom(
            module_path('Reaction', 'Resources/lang'),
            'reaction'
        );
    }
}