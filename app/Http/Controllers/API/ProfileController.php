<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function index(): UserResource
    {
        return new UserResource(auth()->user());
    }
}
