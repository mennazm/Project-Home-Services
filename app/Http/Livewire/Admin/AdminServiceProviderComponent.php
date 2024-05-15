<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\ServiceProvider;

class AdminServiceProviderComponent extends Component
{
    public function render()
    {
        $sproviders = ServiceProvider :: paginate(12);
        return view('livewire.admin.admin-service-provider-component',['sproviders'=>$sproviders])->layout('layouts.base');
    }
}
