<?php

namespace App\Console\Commands;

use App\Module;
use App\Permission;
use App\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ChangeModulePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change permissions as per laratrust_seeder config file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();
        $config = config('laratrust_seeder.role_structure');
        $globalModules = config('laratrust_seeder.role_structure.administrator');
        $mapPermission = collect(config('laratrust_seeder.permissions_map'));

        foreach ($config as $role => $modules) {
            $reqRole = Role::where('name', $role)->withoutGlobalScopes()->first();

            $reqRole->permissions()->detach();
            // Reading role permission modules
            foreach ($modules as $module => $value) {
                $reqModule = Module::where('name', $module)->first();
                $permissions = [];

                foreach (explode(',', $value['permissions']) as $p => $perm) {

                    $permissionValue = $mapPermission->get($perm);

                    $permissions[] = Permission::firstOrCreate([
                        'name' => strtolower($permissionValue . '_' . $module),
                        'display_name' => ucfirst($permissionValue) . ' ' . ucwords(str_replace('_', ' ', $module)),
                        'description' => ucfirst($permissionValue) . ' ' . ucwords(str_replace('_', ' ', $module)),
                        'module_id' => $reqModule->id
                    ])->id;
                }

                $reqRole->permissions()->syncWithoutDetaching($permissions);
            }

        }

        foreach ($globalModules as $module => $value) {
            $reqModule = Module::where('name', $module)->first();

            $reqModule->display_name = ucwords(str_replace('_', ' ', $module));
            $reqModule->description = 'modules.module.'.lcfirst(implode('', explode(' ', ucwords(str_replace('_', ' ', $module.'_description')))));

            $reqModule->save();
        }
        Schema::enableForeignKeyConstraints();
    }
}
