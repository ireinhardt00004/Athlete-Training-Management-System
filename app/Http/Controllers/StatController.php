<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sport;
use App\Models\Material;
class StatController extends Controller
{
    //
    public function statIndex($id) {
    $materials = Material::find($id);
    return view('coach.stats', compact('materials'));
}

}
