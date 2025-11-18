<?php
/**
 * Created by PhpStorm.
 * User: Mohammed
 * Date: 5/18/2016
 * Time: 3:31 PM
 */

namespace App\Entities\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;

trait CategoryTrait
{
    public function scopeFilterByType($query, Request $request)
    {
        if ($request->has('type')) {
            $type = $request->get("type");
            $query = $query->where("type", $type);
        }
        return $query;
    }

    public function scopeYesterdayTender($query)
    {
        $query = $query->whereHas('tender', (function ($query) {
            $query->whereDate('created_at', '=', Carbon::yesterday()->toDateString());
        }));

        return $query;
    }
}
