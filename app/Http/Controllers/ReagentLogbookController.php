<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class ReagentLogbookController extends Controller
{
public function reagentMediaLogbook()
{
    $logbooks = DB::table('reagent_media_logbooks')
        ->orderBy('id', 'asc')
        ->get();

    $users = DB::table('users')
        ->orderBy('f_name', 'asc')
        ->get();

    return view('Reagentmedialogbook.create', compact('logbooks', 'users'));
}

public function storeReagentMediaLogbook(Request $request)
{
    $rowIds = $request->input('row_id', []);

    $columns = [
        'media_batch_no',
        'date_prepared',
        'chemical_media',
        'manufacturer_batch_lot_no',
        'quantity_used',
        'quantity_prepared',
        'ph_required',
        'ph_pre_sterilization',
        'ph_post_sterilization',
        'expiry',
        'physical_appearance',
        'prepared_by',
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

            if ($column === 'date_prepared') {
                $value = empty($value) ? null : $value;
            } else {
                $value = is_null($value) ? null : trim($value);
            }

            $data[$column] = $value;

            if (!empty($value)) {
                $hasValue = true;
            }
        }

        if (!$hasValue) {
            continue;
        }

        $id = $rowIds[$i] ?? null;

        $data['updated_at'] = now();

        if (!empty($id)) {
            DB::table('reagent_media_logbooks')
                ->where('id', $id)
                ->update($data);

            $savedIds[] = (int) $id;
        } else {
            $data['created_at'] = now();

            $newId = DB::table('reagent_media_logbooks')
                ->insertGetId($data);

            $savedIds[] = (int) $newId;
        }
    }

    if (count($savedIds) > 0) {
        DB::table('reagent_media_logbooks')
            ->whereNotIn('id', $savedIds)
            ->delete();
    } else {
        DB::table('reagent_media_logbooks')->delete();
    }

    return redirect()
        ->route('reagent_media_logbook.create')
        ->with('success', 'Reagent and Media Preparation Logbook saved successfully.');
}
}
