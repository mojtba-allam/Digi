<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class ScaffoldModule extends Command
{
   protected $signature = 'module:scaffold {name}';
   protected $description = 'Scaffold a new module with standard Laravel Modular structure';


    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $modulePath = base_path("Modules/{$name}");


        $structure = [
            'database/migrations',
            'database/seeders',
            'database/factories',
            'routes',
            'app/Models/',
            'app/Http/Controllers',
            'app/Http/Middleware',
            'app/Http/Requests',
            'app/Http/Resources',
            'app/Providers',
            'Repositories',
            'Resources/assets/js',
            'Resources/assets/sass',
            'Resources/lang',
            'Resources/views',
            'tests/Feature',
            'tests/Unit',
        ];

        // Create empty service providers
        File::put("$modulePath/app/Providers/{$name}ServiceProvider.php", "<?php\n\nnamespace Modules\\{$name}\\Providers;\n\nuse Illuminate\\Support\\ServiceProvider;\n\nclass {$name}ServiceProvider extends ServiceProvider\n{\n    public function register() {}\n    public function boot() {}\n}");

        File::put("$modulePath/app/Providers/RouteServiceProvider.php", "<?php\n\nnamespace Modules\\{$name}\\Providers;\n\nuse Illuminate\\Support\\ServiceProvider;\n\nclass RouteServiceProvider extends ServiceProvider\n{\n    public function map() {}\n}");

        // Create base route files
        File::put("$modulePath/routes/web.php", "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/', function () {\n    return view('{$name}::welcome');\n});");

        File::put("$modulePath/routes/api.php", "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::prefix('api')->group(function () {\n    Route::get('/', function () {\n        return response()->json(['module' => '{$name}']);\n    });\n});");


       // Create empty service providers
       File::put("$modulePath/app/Providers/{$name}ServiceProvider.php", "<?php\n\nnamespace Modules\\{$name}\\Providers;\n\nuse Illuminate\\Support\\ServiceProvider;\n\nclass {$name}ServiceProvider extends ServiceProvider\n{\n    public function register() {}\n    public function boot() {}\n}");


       File::put("$modulePath/app/Providers/RouteServiceProvider.php", "<?php\n\nnamespace Modules\\{$name}\\Providers;\n\nuse Illuminate\\Support\\ServiceProvider;\n\nclass RouteServiceProvider extends ServiceProvider\n{\n    public function map() {}\n}");


       // Create base route files
       File::put("$modulePath/routes/web.php", "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/', function () {\n    return view('{$name}::welcome');\n});");


       File::put("$modulePath/routes/api.php", "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::prefix('api')->group(function () {\n    Route::get('/', function () {\n        return response()->json(['module' => '{$name}']);\n    });\n});");


       $this->info("Module '{$name}' scaffolded successfully.");
   }
}
