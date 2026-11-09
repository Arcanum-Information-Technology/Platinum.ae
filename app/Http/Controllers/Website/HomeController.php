<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $page = Page::published()->where('slug', 'home')->first();

        if (!$page) {
            abort(404, 'Home page not found');
        }

        return view('website.page', compact('page'));
    }
}
