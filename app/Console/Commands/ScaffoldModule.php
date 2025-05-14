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
            'Database/Migrations',
            'Database/Seeders',
            'Database/Factories',
            'Routes',
            'app/Models/',
            'app/Http/Controllers',
            'app/Http/Middleware',
            'app/Http/Requests',
            'app/Http/Resources',
            'Providers',
            'app/Providers',
            'Repositories',
            'Resources/assets/js',
            'Resources/assets/sass',
            'Resources/lang',
            'Resources/views',
            'Tests/Feature',
            'Tests/Unit',
        ];

        foreach ($structure as $folder) {
            $path = "$modulePath/{$folder}";
            File::makeDirectory($path, 0755, true, true);
        }

        // Create basic module files
        File::put("$modulePath/composer.json", "{}");
        File::put("$modulePath/module.json", json_encode(["name" => $name], JSON_PRETTY_PRINT));
        File::put("$modulePath/package.json", json_encode(["name" => strtolower($name)], JSON_PRETTY_PRINT));
        File::put("$modulePath/webpack.mix.js", "const mix = require('laravel-mix');\n\nmix.js('Resources/assets/js/app.js', 'public/js')\n   .sass('Resources/assets/sass/app.scss', 'public/css');");

        // Create empty service providers
        File::put("$modulePath/Providers/{$name}ServiceProvider.php", "<?php\n\nnamespace Modules\\{$name}\\Providers;\n\nuse Illuminate\\Support\\ServiceProvider;\n\nclass {$name}ServiceProvider extends ServiceProvider\n{\n    public function register() {}\n    public function boot() {}\n}");

        File::put("$modulePath/Providers/RouteServiceProvider.php", "<?php\n\nnamespace Modules\\{$name}\\Providers;\n\nuse Illuminate\\Support\\ServiceProvider;\n\nclass RouteServiceProvider extends ServiceProvider\n{\n    public function map() {}\n}");

        // Create base route files
        File::put("$modulePath/Routes/web.php", "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::get('/', function () {\n    return view('{$name}::welcome');\n});");

        File::put("$modulePath/Routes/api.php", "<?php\n\nuse Illuminate\\Support\\Facades\\Route;\n\nRoute::prefix('api')->group(function () {\n    Route::get('/', function () {\n        return response()->json(['module' => '{$name}']);\n    });\n});");

        $this->info("Module '{$name}' scaffolded successfully.");
    }
}
