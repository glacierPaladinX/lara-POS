<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Verify extends Component
{
    use LivewireAlert;
    
    public function resend()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            redirect(route('home'));
        }

        Auth::user()->sendEmailVerificationNotification();

        $this->emit('resent');

        $this->alert('resent');
    }

    public function render()
    {
        return view('livewire.auth.verify');
    }
}