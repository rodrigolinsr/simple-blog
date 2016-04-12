<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Contracts\Validation\Validator;

class Controller extends BaseController {
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    protected $pageSize = 10;

    protected function redirectBackIfValidatorFails(Validator $validator) {
      if ($validator->fails()) {
        return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
      }

      return null;
    }
}
