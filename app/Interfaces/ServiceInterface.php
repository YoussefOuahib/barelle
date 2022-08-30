<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ServiceInterface {
    public function store(Request $request, integer $id) : void;

    public function delete(integer $id) : void;
}