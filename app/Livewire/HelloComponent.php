<?php

namespace App\Livewire;

use Livewire\Component;

class HelloComponent extends Component
{
    public $input = "";
    public $message = 'no message';

    protected $validate_rule = [
        'input' => 'required|max:255',
    ];

    public function updateMessage()
    {
        $this->validate($this->validate_rule);
        $this->message = 'Updated: ' .$this->input;
    }

    public function render()
    {
        return view('livewire.hello-component');
    }
}
