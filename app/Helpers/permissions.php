<?php

use App\Post;

    // This helper function is used for disabling the others user edit and delete button in the front end
    function check_user_permissions($request,$actionName=NULL,$id = NULL)
    {
        // get current user login
        $currentUser = $request->user();
        // dd($currentUser);   

        // get current action name
        if($actionName)
        {
            $currentActionName = $actionName;   // gets the controller path here
        }
        else
        {
            $currentActionName = $request->route()->getActionName();    // gets the full controller path 
        }

        list($controller,$method) = explode('@',$currentActionName);    # separates according to the @ 
        $controller = str_replace(["App\\Http\\Controllers\\Backend\\","Controller"],"",$controller);

        $crudPermissionMaps = [

            // 'create' =>['create','store'],    # create will be mapped as create and store method in controller
            // 'update' => ['edit','update'],      # update will be mapped as edit and update method in controller
            // 'delete'=> ['destroy','restore','forceDestroy'],  # delete will be mapped as destroy,restore and forcedestroy method in controller
            // 'read' =>['index','view']               # read will be mapped as index and view method in controller

            'crud' => ['create','store','edit','update','destroy','restore','forceDestroy','index','view'],
        ];

        $crudClassesMaps = [

            'Blog' => 'post',
            'Categories' => 'category',
            'Users' => 'user'
        ];

        foreach($crudPermissionMaps as $permission => $methods)
        {  
            // if the current method exists in the current method list 
            // we will check the permission
            if(in_array($method,$methods) && isset($crudClassesMaps[$controller]))
            {
                $className = $crudClassesMaps[$controller];

                if($className == 'post' && in_array($method,['edit','update','destroy','restore','forceDestroy']))
                {
                    // current user cannot update-others-posts/delete-others-posts permission
                    // current user can modify his/her own posts 
                    $id = !is_null($id) ? $id : $request->route("blog");

                    // gets the update-others-post and delete-others-post from permission table seeder that is contained by Post model
                    if( ($id) && (!$currentUser->can('update-others-post') || !$currentUser->can('delete-others-post')))
                    {
                        // gets the post by id
                        $post = Post::withTrashed()->findOrFail($id);
                        if($post->author_id !== $currentUser->id)
                        {
                            return false;
                            // abort(403,"Forbidden Access");
                            // return redirect('/backend/blog')->with('message-temp','Cannot edit/Delete other user posts');
                        }
                    }
                }
                
                // if the user has not permission don't allow the next request
                elseif(! $currentUser->can("{$permission}-{$className}"))
                {
                    return false;
                    // abort(403,"Forbidden Access");
                } 
                break;
            }
        }
        return true; 
    } 