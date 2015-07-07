<?php
namespace App\Http\Controllers;

use App\Report;
use App\User;
use App\Record;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use Auth;

class ReportController extends Controller
{
    public function get(Request $request, $date)
    {

        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        } else {
            $user = Auth::user();
            if ($user->compentent != User::COMMISSIONER and $user->compentent != User::MINISTER and $user->compentent != User::LEADER) {
                return response(array('error' => 'user not compentent', 'ret' => false));
            }
        }

        try {
            
            $match = array();
            $cnt = preg_match_all('/\d{4}|\d{2}/', $date, $match);
            switch ($cnt) {
                case 1:
                    $datetime = new \DateTime($date.'-01-01');
                    $current = $datetime->format('Y-m-d H:i:s');
                    $datetime->modify('+1 year');
                    $next = $datetime->format('Y-m-d H:i:s');
                    break;
                case 2:
                    $datetime = new \DateTime($date);
                    $current = $datetime->format('Y-m-d H:i:s');
                    $datetime->modify('+1 month');
                    $next = $datetime->format('Y-m-d H:i:s');
                    break;
                case 3:
                    $datetime = new \DateTime($date);
                    $current = $datetime->format('Y-m-d H:i:s');
                    $datetime->modify('+1 day');
                    $next = $datetime->format('Y-m-d H:i:s');
                    break;
                default:
                    return response(array('ret' => false, 'err' => 'report: date is error'));
            }

            DB::setFetchMode(\PDO::FETCH_ASSOC);
            $reports = DB::table('report')->select(DB::raw('item_id, item.name as iname, user_id, users.name as uname, type, bill, bill_degree, degree, date'))
                                          ->join('item', 'item.id', '=', 'report.item_id')
                                          ->join('users', 'users.id', '=', 'report.user_id')
                                          ->where('date', '>=', $current)
                                          ->where('date', '<', $next)
                                          ->where('type', '=', $cnt)
                                          ->groupBy('item_id')
                                          ->orderBy('date')
                                          ->get();

            DB::setFetchMode(\PDO::FETCH_CLASS);

            return response($reports);

        } catch (\Exception $e) {
            return response(array('ret' => false));
        }
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        } else {
            $user = Auth::user();
            if ($user->compentent != User::COMMISSIONER and $user->compentent != User::MINISTER and $user->compentent != User::LEADER) {
                return response(array('error' => 'user not compentent', 'ret' => false));
            }
        }

        $date = $request->input('date', date('Y-m-d'));
        $item_id = $request->input('item_id');
        if ($item_id == null) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }
        $bill = $request->input('bill');
        $bill_degree = $request->input('bill_degree');

        $match = array();
        $cnt = preg_match_all('/\d{4}|\d{2}/', $date, $match);
        switch ($cnt) {
            case 1:
                $datetime = new \DateTime($date.'-01-01');
                $current = $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+1 year');
                $next = $datetime->format('Y-m-d H:i:s');
                break;
            case 2:
                $datetime = new \DateTime($date);
                $current = $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+1 month');
                $next = $datetime->format('Y-m-d H:i:s');
                break;
            case 3:
                $datetime = new \DateTime($date);
                $current = $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+1 day');
                $next = $datetime->format('Y-m-d H:i:s');
                break;
            default:
                return response(array('ret' => false, 'error' => 'report: date is error'));
        }
        DB::setFetchMode(\PDO::FETCH_ASSOC);

        $records = DB::table('records')->select(DB::raw('item_id, SUM(degree) as degree, date'))
            ->where('date', '>=', $current)
            ->where('date', '<', $next)
            ->where('item_id', '=', $item_id)
            ->orderBy('date')
            ->get();
        DB::setFetchMode(\PDO::FETCH_CLASS);

        if (count($records) == 0 || $records[0]['item_id'] == null) {
            $records[0] = array(
                'item_id' => $item_id,
                'degree' => 0,
                'date' => $date
            );
        }

        $user = Auth::user();
        $records[0]['user_id'] = $user->id;
        $reportsss = Report::where('date', '>=', $current)
            ->where('date', '<', $next)
            ->where('type', '=', $cnt)
            ->where('item_id', '=', $item_id)
            ->update(
                array_merge($records[0], array('bill_degree' => $bill_degree, 'bill' => $bill, 'type' => $cnt))
            );
        return response(array('ret' => true, 'success' => 'update report success'));
    }

    public function create(Request $request)
    {
        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        } else {
            $user = Auth::user();
            if ($user->compentent != User::COMMISSIONER and $user->compentent != User::MINISTER and $user->compentent != User::LEADER) {
                return response(array('error' => 'user not compentent', 'ret' => false));
            }
        }


        $date = $request->input('date', date('Y-m-d'));
        $item_id = $request->input('item_id');
        if ($item_id == null) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }
        $bill = $request->input('bill', 0);
        $bill_degree = $request->input('bill_degree');

        $match = array();
        $cnt = preg_match_all('/\d{4}|\d{2}/', $date, $match);
        switch ($cnt) {
            case 1:
                $datetime = new \DateTime($date.'-01-01');
                $current = $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+1 year');
                $next = $datetime->format('Y-m-d H:i:s');
                break;
            case 2:
                $datetime = new \DateTime($date);
                $current = $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+1 month');
                $next = $datetime->format('Y-m-d H:i:s');
                break;
            case 3:
                $datetime = new \DateTime($date);
                $current = $datetime->format('Y-m-d H:i:s');
                $datetime->modify('+1 day');
                $next = $datetime->format('Y-m-d H:i:s');
                break;
            default:
                return response(array('ret' => false, 'error' => 'report: date is error'));
        }
        DB::setFetchMode(\PDO::FETCH_ASSOC);

        $records = DB::table('records')->select(DB::raw('item_id, SUM(degree) as degree, date'))
            ->where('date', '>=', $current)
            ->where('date', '<', $next)
            ->where('item_id', '=', $item_id)
            ->orderBy('date')
            ->get();
        DB::setFetchMode(\PDO::FETCH_CLASS);

        if (count($records) == 0) {
            $records[0] = array(
               'item_id' => $item_id,
               'degree' => 0,
               'date' => $date
           );
        }

        if ($records[0]['item_id'] == null) {
            $records[0] = array(
                'item_id' => $item_id,
                'degree' => 0,
                'date' => $date
            );
        }

        try {
            $user = Auth::user();
            $records[0]['user_id'] = $user->id;
            Report::firstOrCreate(
                    array_merge($records[0], array('bill_degree' => $bill_degree, 'bill' => $bill, 'type' => $cnt))
                );
            return response(array('ret' => true, 'success' => 'create report success'));
        } catch (\Exception $e) {
            return response(array('ret' => false, 'error' => 'report: '.$e->getMessage()));
        }

    }
}
