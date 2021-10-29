<?php

namespace App\Http\Livewire;

use App\Models\User as Person;
use Livewire\Component;

class User extends Component
{
    public function render()
    {
        $users = Person::orderBy('id', 'ASC')->get();

        return view('livewire.user', compact('users'));
    }
}
