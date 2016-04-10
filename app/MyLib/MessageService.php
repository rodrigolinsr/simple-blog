<?php
namespace App\MyLib;

class MessageService {
  const TYPE_SUCCESS = 'success';
  const TYPE_ERROR = 'danger';
  const TYPE_WARNING = 'warning';
  const TYPE_INFO = 'info';

  private $messages = [];

  public function addMessage(string $type, string $text) : bool {
    $this->messages[] = ['type' => $type, 'text' => $text];
    return true;
  }

  public function removeMessage(int $index) : bool {
    if(isset($this->messages[$index])) {
      unset($this->messages[$index]);
      return true;
    }

    return false;
  }

  public function getMessages() : array {
    return $this->messages;
  }
}
