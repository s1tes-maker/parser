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

    public function main_full_menu(Request $request) {
        if(!$user = $request->user()) {
            response()->json(['status'=>401]);
        }

        return response()->json(['status'=>200, 'body'=>Menu::all()]);
    }
}
