<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // for resetting the table
        DB::table('permissions')->truncate();

        // crud post
        $crudpost = new Permission();
        $crudpost->name = "crud-post";
        $crudpost->save();

        // update others post
        $updateOthersPost = new Permission();
        $updateOthersPost->name = "update-others-post";
        $updateOthersPost->save();

        // delete others post
        $deleteOthersPost = new Permission();
        $deleteOthersPost->name = "delete-others-post";
        $deleteOthersPost->save();

        // crud category
        $crudcategory = new Permission();
        $crudcategory->name = "crud-category";
        $crudcategory->save();

        // crud user
        $cruduser = new Permission();
        $cruduser->name = "crud-user";
        $cruduser->save();

        // attach permission to the roles
        $admin = Role::whereName('admin')->first();
        $editor = Role::whereName('editor')->first();
        $author = Role::whereName('author')->first();

        $admin->detachPermissions([$crudpost,$updateOthersPost,$deleteOthersPost,$crudcategory, $cruduser]);
        $admin->attachPermissions([$crudpost,$updateOthersPost,$deleteOthersPost,$crudcategory, $cruduser]);
        
        $editor->detachPermissions([$crudpost,$updateOthersPost,$deleteOthersPost,$crudcategory]);
        $editor->attachPermissions([$crudpost,$updateOthersPost,$deleteOthersPost,$crudcategory]);
        
        $author->detachPermission($crudpost);
        $author->attachPermission($crudpost);

    }
}
