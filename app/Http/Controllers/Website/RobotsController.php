<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function index(): Response
    {
        $siteUrl = config('app.url', url('/'));

        $robots = <<<ROBOTS
User-agent: *
Allow: /
Disallow: /admin/
Disallow: /login
Disallow: /password/
Disallow: /build/

Sitemap: {$siteUrl}/sitemap.xml
ROBOTS;

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
