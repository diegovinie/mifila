<?php

namespace App\Http\Controllers\Api;

use App\Config;
use App\ConfigItem as Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Config::with('current')->get();
    }

    public function items(Config $config)
    {
        return $config->items;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config)
    {
        //
        return $config->load('current');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Config  $config
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $config)
    {
        //
        $item = Item::findOrFail($request->item);

        if ($item->config_id != $config->id) {
            throw new \Exception('El item no coincide.');
        }

        $config->current()->associate($item);
        $config->save();

        return $config;
    }
}
