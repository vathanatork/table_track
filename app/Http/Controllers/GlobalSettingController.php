<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GlobalSettingController extends Controller
{

    public function index()
    {

        try {
            $results = DB::select('select version()');
            $mysql_version = $results[0]->{'version()'};
            $databaseType = 'MySQL Version';

            if (str_contains($mysql_version, 'Maria')) {
                $databaseType = 'Maria Version';
            }
        } catch (\Exception $e) {
            $mysql_version = null;
            $databaseType = 'MySQL Version';
        }

        $reviewed = file_exists(storage_path('reviewed'));
        
        return view('app_update.index', compact('mysql_version', 'databaseType', 'reviewed'));
    }

}
