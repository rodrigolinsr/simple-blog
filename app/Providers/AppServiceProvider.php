<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\MyLib\BlogSettings;

use App\Models\{Category, Tag};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      $blogSettingsIni = BlogSettings::getSettings();
      view()->share('generalBlogTitle', $blogSettingsIni['blog_title']);
      view()->share('generalBlogDescription', $blogSettingsIni['blog_description']);

      $categories = Category::all();
      $tags = Tag::all();

      view()->share('generalBlogCategories', $categories);
      view()->share('generalBlogTags', $tags);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
