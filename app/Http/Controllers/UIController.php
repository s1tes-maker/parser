<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Menu;
use Illuminate\Http\Request;


class UIController extends Controller
{
    public function main_menu(Request $request){
        if(!$user = $request->user()) {
            response()->json(['status'=>401]);
        }

        $role = $user->role;
        $menus = Role::find($role->id)->menus()->orderBy('order')->get();

        return response()->json(['status'=>200, 'body'=>$menus]);
    }

    public function auth_page(Request $request) {
        if(!$user = $request->user()) {
            response()->json(['status'=>401]);
        }

        if(!$punkt_menu = Menu::where('key', $request->page_name)->first())
            return response()->json(['status'=>200, 'message'=>404]);

        $role = $user->role;
        if(!$punkt_menu = Role::find($role->id)->menus()->where('key', $request->page_name)->first())
            return response()->json(['status'=>200, 'message'=>403]);

        return response()->json(['status'=>200, 'message'=>200]);
    }
}
