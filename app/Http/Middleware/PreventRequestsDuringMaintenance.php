<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;

class PreventRequestsDuringMaintenance extends CheckForMaintenanceMode {}
