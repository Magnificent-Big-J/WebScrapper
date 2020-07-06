<?php

namespace App\Http\Controllers;

use App\Services\WebScraperService;
use Illuminate\Http\Request;

class WebScraperController extends Controller
{
    public function index(WebScraperService $webScraperService)
    {
        $url = 'https://stackoverflow.com/jobs?l=South+Africa&d=20&u=Km';
        $data = $webScraperService->WebScraper($url);

        return view('welcome', $data);
    }
}
