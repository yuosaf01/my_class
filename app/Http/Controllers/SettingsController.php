<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    public function create($key, $type, $value) {
        return Settings::create([
            'key' => $key,
            'type' => $type,
            'value' => $value
        ]);
    }

    public function update($key, $value) {
        return Settings::where('key', $key)->update([
            'value' => $value
        ]);
    }

    public function get($key) {
        return Settings::whereKey($key)->first();
    }
}
