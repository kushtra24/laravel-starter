<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     /**
     * Parse given string to array by (optional) delimiter
     *
     * @param $string
     * @param string $delimiter
     * @param bool $removeEmptyEntries
     * @param bool $trimEntries
     * @return array|null
     */
    public static function stringToArray($string, $delimiter = ',', $removeEmptyEntries = true, $trimEntries = true) {
        if(!is_null($string) && gettype($string) === 'string') {
            // get array
            $array = explode($delimiter, $string);
            // trim entries
            if($trimEntries) {
                $array = array_map('trim', $array);
            }
            // remove empty entries
            if($removeEmptyEntries) {
                $array = array_filter($array, 'strlen');
            }
            return $array;
        }
        return null;
    }

    protected function executeQuery(&$query = null, $page = null, $limit = null, $orderByArr = null, $orderType = 'asc') {
        $result = null;
        if(!isset($query)) { return null; }

//        Log::info('HERE: ' . var_export($query, true));

        // order by array
        if(is_countable($orderByArr) && count($orderByArr) > 0) {
            // check sort ranking
            if(!isset($orderType) || $orderType !== 'desc' && $orderType !== 'asc') {
                $orderType = 'asc';
            }

            // create order by
            for($i = 0, $max = count($orderByArr); $i < $max; $i++) {
                $attr = $orderByArr[$i];
                if(!isset($attr)) { continue; }
                $query = $query->orderBy($attr, $orderType);
            }
        }

        // check for pagination
        if(isset($page) && $page > 0) {
            // check limit
            if(!isset($limit) || $limit <= 0) { $limit = 8; }
            // execute
            $result = $query->paginate($limit);
        } else {
            // check for limit
            if(isset($limit) && $limit > 0) {
                $query = $query->limit($limit);
            }
            $result = $query->get();
//            $result = $query->paginate($limit); // laravel doing pagination (slow)

        }

        return $result;
    }
    
}
