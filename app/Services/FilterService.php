<?php
namespace App\Services;

class FilterService
{

	public function byDate($query, $request)
	{
		if($request->has('date_from'))
			$query->whereDate('date', '>', $request->input('date_from'));

		if($request->has('date_to'))
			$query->whereDate('date', '<', $request->input('date_to'));

		return $query;
	}
}