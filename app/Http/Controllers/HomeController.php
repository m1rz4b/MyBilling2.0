<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Helpers\FolderHelper;
use Illuminate\Support\Facades\Storage;

use function App\Helpers\createClientFolders;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        return view('admin.dashboard',compact('menus'));
    }

    public function permission_page()
    {
        $menus = Menu::where('status',1)->get();
        return view('pages.company.userAndAuthorization.permissions', compact('menus'));
    }

    public function user_page()
    {
        $menus = Menu::where('status',1)->get();
        return view('pages.company.userAndAuthorization.user', compact('menus'));
    }

    public function roles_page()
    {
        $menus = Menu::where('status',1)->get();
        return view('pages.company.userAndAuthorization.roles', compact('menus'));
    }
}
