<?php

namespace App\Http\Controllers;

use App\Models\Distict;
use App\Models\Member;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function fetchAllDicticts(Request $request){
        // dd($select);
        $select = $request->select;
        $disticts = Distict::query()->when(!is_null($select) , function($query) use($select){
            $query->select($select);
        })->get();
        return response()->json($disticts);
    }

    public function getMembers(Request $request){
        $select = isset($request->select) ? $request->select : null;
        $with = isset($request->with) ? $request->with : null;
        $where = isset($request->where) ?  $request->where: null;

        // dd($where, $request->where, $request->query(), $request->where, $where, [$where[0]], [['status', '=', 'active']]);
        $members = Member::query()
        ->when(!is_null($select), function($query) use($select){
            return $query->select($select);
        })
        ->when(!is_null($with), function($query) use($with){
            return $query->with($with);
        })
        ->when(!is_null($where), function($query) use($where){
            return $query->where([$where[0]]);
        })
        ->get();
        return response()->json($members);
    }
}
