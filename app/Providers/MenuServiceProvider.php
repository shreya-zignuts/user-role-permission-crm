<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
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

    if ($routePrefix === 'admin') {
      $menuData = $this->getAdminMenuData();
    } else {
      $menuData = $this->getUserMenuData();
    }

    \View::share('menuData', $menuData);
  }

  /**
   * Get menu data for admin.
   */
  private function getAdminMenuData()
  {
    $verticalMenuFile = 'verticalMenu.json';
    $horizontalMenuFile = 'horizontalMenu.json';

    $verticalMenuJson = file_get_contents(base_path('resources/menu/' . $verticalMenuFile));
    $horizontalMenuJson = file_get_contents(base_path('resources/menu/' . $horizontalMenuFile));

    // $verticalMenuData = json_decode($verticalMenuJson);
    // $horizontalMenuData = json_decode($horizontalMenuJson);

    return [
      'verticalMenuData' => json_decode($verticalMenuJson),
      'horizontalMenuData' => json_decode($horizontalMenuJson),
    ];
  }

  /**
   * Get menu data for user.
   */
  private function getUserMenuData()
  {
    // $modules = Module::all();
    // $user = Auth::user();
    // dd($user);

    $verticalMenuFile = 'userVerticalMenu.json';
    $horizontalMenuFile = 'userHorizontalMenu.json';

    $verticalMenuJson = file_get_contents(base_path('resources/menu/' . $verticalMenuFile));
    $horizontalMenuJson = file_get_contents(base_path('resources/menu/' . $horizontalMenuFile));

    // $verticalMenuData = json_decode($verticalMenuJson);
    // $horizontalMenuData = json_decode($horizontalMenuJson);

    return [
      'verticalMenuData' => json_decode($verticalMenuJson),
      'horizontalMenuData' => json_decode($horizontalMenuJson),
      // 'modules' => $modules,
    ];
  }
}
