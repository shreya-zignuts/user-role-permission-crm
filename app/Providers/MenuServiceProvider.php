<?php

namespace App\Providers;

use App\Models\Module;
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
    $modules = Module::whereNull('parent_code')
      ->with('submodules')
      ->get();

    // dd($modules);
    $menuItems = [];

    foreach ($modules as $module) {
      $moduleItem = [
        'url' => '/userside/module/' . $module->code, // Example URL for the module
        'icon' => $module->icon, // Icon for the module
        'name' => $module->name,
        'slug' => 'module-' . $module->code,
        'submenu' => [],
      ];

      // Loop through submodules of the current module
      foreach ($module->submodules as $submodule) {
        $submoduleItem = [
          'url' => '/userside/submodule/' . $submodule->code, // Example URL for the submodule
          'name' => $submodule->name,
          'slug' => 'submodule-' . $submodule->code,
        ];

        // Add the submodule to the module's submenu
        $moduleItem['submenu'][] = $submoduleItem;
      }

      // Add the module item to the main menu
      $menuItems[] = $moduleItem;
    }

    // Convert the menuItems array to JSON format
    $moduleJson = json_encode(['menu' => $menuItems], JSON_PRETTY_PRINT);

    // Save the JSON data to a file (you can choose your file location)
    file_put_contents(storage_path('app/menu.json'), $moduleJson);

    // dd($modules);

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
    \View::share('menuData', [$verticalMenuData, $horizontalMenuData, $moduleJson]);
  }
}
