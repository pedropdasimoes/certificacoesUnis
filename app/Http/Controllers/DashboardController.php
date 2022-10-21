<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Google\Service\IAMCredentials\GenerateAccessTokenRequest;
use App\Models\User;

class DashboardController extends Controller
{

    private $objUser;

    public function __construct()
    {
        $this->objUser = new User();
    }
    public function index()
    {
        $userAuth = auth()->user();
        return Inertia::render('Dashboard');
    }
}
