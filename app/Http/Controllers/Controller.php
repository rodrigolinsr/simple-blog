<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

use App\MyLib\MessageService;

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

    protected function validateEntity(Request $request, Validator $validator) {
      if($result = $this->redirectBackIfValidatorFails($validator)) {
        $service = new MessageService();
        $service->addMessage(MessageService::TYPE_ERROR, "Please, check the data you've submitted and try again.");
        $request->session()->flash('flashMessages', $service->getMessages());

        return $result;
      }

      return null;
    }
}
