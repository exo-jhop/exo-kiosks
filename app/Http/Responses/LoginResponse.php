<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use Filament\Pages\Dashboard;
use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginResponse extends BaseLoginResponse
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = Auth::user();

        Log::info('LoginResponse triggered', ['user_id' => $user?->id, 'roles' => $user?->getRoleNames()->toArray()]);

        if ($user) {
            if ($user->hasRole('kitchen')) {
                $kitchenPanel = \Filament\Facades\Filament::getPanel('kitchen');
                return redirect()->to($kitchenPanel->getUrl());
            }

            if ($user->is_admin) {
                $adminPanel = \Filament\Facades\Filament::getPanel('admin');
                return redirect()->to($adminPanel->getUrl());
            }
        }


        Log::info('Using default login response');

        return parent::toResponse($request);
    }
}
