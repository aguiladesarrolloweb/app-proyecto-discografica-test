<?php

namespace App\Livewire;

use Livewire\Component;

class LanguageSelector extends Component
{
    public $lang;

    public function mount()
    {
        $this->lang = session('locale', config('app.locale'));
    }

    public function render()
    {
        return view('livewire.language-selector');
    }


    public function changeLanguage($lang)
    {
        if (in_array($lang, ['es', 'en', 'pt'])) {
            session(['locale' => $lang]);
            app()->setLocale($lang);
        }
    }
}
