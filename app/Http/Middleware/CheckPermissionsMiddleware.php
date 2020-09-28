<?php

namespace App\Http\Middleware;

use Closure;
// use App\Post;

class CheckPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // // get current user login
        // $currentUser = $request->user();

        // // get current action name
        // $currentActionName = $request->route()->getActionName();      // gets the full controller path along with name
        // list($controller,$method) = explode('@',$currentActionName);    # separates according to the @ 
        // $controller = str_replace(["App\\Http\\Controllers\\Backend\\","Controller"],"",$controller);

        // $crudPermissionMaps = [

        //     // 'create' =>['create','store'],    # create will be mapped as create and store method in controller
        //     // 'update' => ['edit','update'],      # update will be mapped as edit and update method in controller
        //     // 'delete'=> ['destroy','restore','forceDestroy'],  # delete will be mapped as destroy,restore and forcedestroy method in controller
        //     // 'read' =>['index','view']               # read will be mapped as index and view method in controller

        //     'crud' => ['create','store','edit','update','destroy','restore','forceDestroy','index','view'],
        // ];

        // $crudClassesMaps = [

        //     'Blog' => 'post',
        //     'Categories' => 'category',
        //     'Users' => 'user'
        // ];

        // foreach($crudPermissionMaps as $permission => $methods)
        // {  
        //     // if the current method exists in the current method list
        //     // we will check the permission
        //     if(in_array($method,$methods) && isset($crudClassesMaps[$controller]))
        //     {
        //         $className = $crudClassesMaps[$controller];

        //         if($className == 'post' && in_array($method,['edit','update','destroy','restore','forceDestroy']))
        //         {
        //             // current user cannot update-others-posts/delete-others-posts permission
        //             // current user can modify his/her own posts 
        //             $id = $request->route("blog");
        //             if( ($id) && (!$currentUser->can('update-others-post') || !$currentUser->can('delete-others-post')))
        //             {
        //                 // gets the post by id
        //                 $post = Post::findOrFail($id);
        //                 if($post->author_id !== $currentUser->id)
        //                 {
        //                     abort(403,"Forbidden Access");
        //                     // return redirect('/backend/blog')->with('message-temp','Cannot edit/Delete other user posts');
        //                 }
        //             }
        //         }

        //         // if the user has not permission don't allow the next request
        //         elseif(! $currentUser->can("{$permission}-{$className}"))
        //         {
        //             abort(403,"Forbidden Access");
        //         } 
        //         break;
        //     }
        // }
        

        if( !check_user_permissions($request))   // if user dont have permission 
        {
            abort(403,"Forbidden Access!");
        }
        return $next($request);            // if have permission will execute it
    }
}
