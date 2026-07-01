<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SterilityCheckController extends Controller
{
   public function sterilityCheck()
{
    $sterilityChecks = DB::table('sterility_checks')
        ->orderBy('id', 'asc')
        ->get();

    $users = DB::table('users')
        ->orderBy('f_name', 'asc')
        ->get();

    return view('Sterilitycheck.create', compact('sterilityChecks', 'users'));
}

public function storeSterilityCheck(Request $request)
{
    $rowIds = $request->input('row_id', []);

    $columns = [
        'date',
        'batch_no',
        'temperature_time_pressure',
        'autoclave_tape',
        'biological_indicator',
        'checked_by',
    ];

    $maxRows = 0;

    foreach ($columns as $column) {
        $items = $request->input($column, []);
        $maxRows = max($maxRows, is_array($items) ? count($items) : 0);
    }

    $savedIds = [];

    for ($i = 0; $i < $maxRows; $i++) {
        $hasValue = false;
        $data = [];

        foreach ($columns as $column) {
            $value = $request->input($column . '.' . $i);

            if ($column === 'date') {
                $value = empty($value) ? null : $value;
            } else {
                $value = is_null($value) ? null : trim($value);
            }

            $data[$column] = $value;

            if (!empty($value)) {
                $hasValue = true;
            }
        }

        // blank row will not be saved
        if (!$hasValue) {
            continue;
        }

        $id = $rowIds[$i] ?? null;

        $data['updated_at'] = now();

        if (!empty($id)) {
            DB::table('sterility_checks')
                ->where('id', $id)
                ->update($data);

            $savedIds[] = (int) $id;
        } else {
            $data['created_at'] = now();

            $newId = DB::table('sterility_checks')
                ->insertGetId($data);

            $savedIds[] = (int) $newId;
        }
    }

    // delete rows removed from form
    if (count($savedIds) > 0) {
        DB::table('sterility_checks')
            ->whereNotIn('id', $savedIds)
            ->delete();
    } else {
        DB::table('sterility_checks')->delete();
    }

    return redirect()
        ->route('sterility_check.create')
        ->with('success', 'Sterility Check saved successfully.');
}
}
