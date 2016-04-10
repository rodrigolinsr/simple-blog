<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  /**
   * Show the administration dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('admin.index');
  }
}
