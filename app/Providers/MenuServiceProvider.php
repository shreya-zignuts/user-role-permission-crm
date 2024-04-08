<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $path = request()->path();

    $segments = explode('/', $path);
    $routePrefix = $segments[0]; // Get the first segment of the path

    $menuType = $routePrefix === 'admin' ? 'admin' : 'user';

    // Determine the menu files based on the menu type
    $verticalMenuFile = $menuType === 'admin' ? 'verticalMenu.json' : 'userVerticalMenu.json';
    $horizontalMenuFile = $menuType === 'admin' ? 'horizontalMenu.json' : 'userHorizontalMenu.json';

    $verticalMenuJson = file_get_contents(base_path('resources/menu/' . $verticalMenuFile));
    $horizontalMenuJson = file_get_contents(base_path('resources/menu/' . $horizontalMenuFile));

    $verticalMenuData = json_decode($verticalMenuJson);
    $horizontalMenuData = json_decode($horizontalMenuJson);

    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData, $horizontalMenuData]);
  }
}
