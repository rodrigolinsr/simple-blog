<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\MyLib\BlogSettings;

class IndexController extends Controller
{
    protected function index()
    {
      $blogSettingsIni = BlogSettings::getSettings();

      return view('index')->with('welcomeTitle', $blogSettingsIni['welcome_title'])
                          ->with('welcomeMessage', $blogSettingsIni['welcome_message']);
    }
}
