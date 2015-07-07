<?php
namespace App\Http\Controllers;

use App\Record;
use App\ItemData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;

class RecordController extends Controller
{
    private function hasItem($token)
    {
        try {
            $ret = DB::table('itemdata')->where('token', '=', $token)->get();
            return (count($ret) > 0) ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function create(Request $request)
    {

        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }

        try {
            if (!$this->hasItem($request->input('item_token'))) {
                return response(array('error' => 'item not exist', 'ret' => false));
            }

            $user = Auth::user();
            $tmpRecord = DB::table('records')->where('item_token', '=', $request->input('item_token'))
                                ->where('date', '=', date('Y-m-d'))
                                ->get();

            if ($tmpRecord) {
                return response($tmpRecord);
            }

            $record = Record::firstOrCreate(
                array(
                    'item_id' => $request->input('item_id'),
                    'user_id' => $user->id,
                    'degree' => $request->input('degree'),
                    'item_token' => $request->input('item_token'),
                    'date' => date('Y-m-d')
                )
            );
            return response(
                array(
                    'id' => $record->id,
                    'item_id' => $record->item_id,
                    'user_id' => $record->user_id,
                    'degree' => $record->degree,
                    'item_token' => $record->item_token,
                    'date' => $record->date
                )
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }

    public function update(Request $request)
    {

        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }

        $user = Auth::user();
        $data = array(
            'id' => $request->input('id'),
            'user_id' => $user->id,
            'degree' => $request->input('degree'),
        );

        $record = Record::find($data['id']);
        foreach ($data as $k => $v) {
            if ($v == null) {
                if ($k == 'date') {
                    $data[$k] = substr($record[$k], 0, 10);
                    continue;
                }
                $data[$k] = $record[$k];
            }
        }

        Record::where('id', '=', $data['id'])->update($data);
        try {
            $records = Record::where('id', '=', $data['id'])->firstOrFail();
            return response(
                array(
                    'id' => $records['id'],
                    'item_id' => $records['item_id'],
                    'user_id' => $user->id,
                    'degree' => $records['degree'],
                    'date' => $records['date'],
                    'item_token' => $records['item_token'],
                )
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }

    public function delete(Request $request)
    {

        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }

        $id = $request->input('id');
        Record::find($id)->delete();

        try {
            $data = Record::where('id', '=', $id)->firstOrFail();
            if (count($data) == 0) {
                return response(array('ret' => true));
            } else {
                return response(array('ret' => false));
            }
        } catch (\Exception $e) {
            return response(array('ret' => true));
        }
    }

    public function has(Request $request)
    {

        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }

        $name = $request->input('name');
        try {
            $item = Item::where('name', '=', $name)->firstOrFail();
            return response(array('ret' => true));
        } catch (\Exception $e) {
            return response(array('ret' => false));
        }
    }

    public function get(Request $request)
    {
        try {

            if (!Auth::check()) {
                return response(array('error' => 'user not auth', 'ret' => false));
            }

            $records = DB::table('records')->select('records.id', 'item_id', 'user_id', 'users.name AS uname', 'item.name AS iname', 'degree', 'date', 'item_token')
                    ->join('users', 'users.id', '=', 'records.user_id')
                    ->join('item', 'item.id', '=', 'records.item_id')->get();
            return response(
                $records
            );
        } catch (\Exception $e) {
            return response(array('ret' => false, 'error' => $e->getMessage()));
        }
    }

    public function getForItemId(Request $request, $id)
    {
        try {

            if (!Auth::check()) {
                return response(array('error' => 'user not auth', 'ret' => false));
            }

            $date = date('Y-m-d');
            $datetime = new \DateTime($date);
            $datetime->modify('+1 day');
            $next = $datetime->format('Y-m-d');
            $records = DB::table('records')
                ->where('item_id', '=', $id)
                ->where('date', '>=', $date)
                ->where('date', '<', $next)
                ->select('id', 'item_id', 'user_id', 'degree', 'date', 'item_token')->get();
            return response(
                $records
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }

    public function getForUserId(Request $request, $id = null)
    {
        try {

            if (!Auth::check()) {
                return response(array('error' => 'user not auth', 'ret' => false));
            }

            if ($id == null) {
                $user = Auth::user();
                $id = $user->id;
            }

            $date = date('Y-m-d');
            $datetime = new \DateTime($date);
            $datetime->modify('+1 day');
            $next = $datetime->format('Y-m-d');
            $records = DB::table('records')
                ->join('users', 'users.id', '=', 'records.user_id')
                ->join('item', 'item.id', '=', 'records.item_id')
                ->where('user_id', '=', $id)
                ->where('date', '>=', $date)
                ->where('date', '<', $next)
                ->select('records.id', 'item_id', 'user_id', 'users.name AS uname', 'item.name AS iname', 'degree', 'date', 'item_token')->get();
            return response(
                $records
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }

    public function getForDate(Request $request, $date)
    {
        try {

            if (!Auth::check()) {
                return response(array('error' => 'user not auth', 'ret' => false));
            }

            $match = array();
            $cnt = preg_match_all('/\d{4}|\d{2}/', $date, $match);

            if ($cnt != 3) {
                return response(array('error' => 'date error', 'ret' => false));
            }

            $datetime = new \DateTime($date);
            $datetime->modify('+1 day');
            $next = $datetime->format('Y-m-d');
            $records = DB::table('records')
                ->where('date', '>=', $date)
                ->where('date', '<', $next)
                ->select('id', 'item_id', 'user_id', 'degree', 'date', 'item_token')->get();
            return response(
                $records
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }

    public function createForMobile(Request $request)
    {
        try {
            $token = $request->input('item_token');
            if (!$this->hasItem($token)) {
                return response(array('error' => 'item not exist', 'ret' => false));
            }

            $items = DB::table('itemdata')->where('token', '=', $token)->get();
            $record = Record::firstOrCreate(
                array(
                    'item_id' => $items[0]->item_id,
                    'user_id' => $request->input('user_id'),
                    'degree' => $request->input('degree'),
                    'item_token' => $token,
                    'date' => date('Y-m-d')
                )
            );
            return response(
                array(
                    'id' => $record->id,
                    'item_id' => $record->item_id,
                    'user_id' => $record->user_id,
                    'degree' => $record->degree,
                    'item_token' => $record->item_token,
                    'date' => $record->date
                )
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }

    public function getForMobile(Request $request, $id)
    {
        try {
            $date = date('Y-m-d');
            $datetime = new \DateTime($date);
            $datetime->modify('+1 day');
            $next = $datetime->format('Y-m-d');
            $records = DB::table('records')
                ->where('user_id', '=', $id)
                ->where('date', '>=', $date)
                ->where('date', '<', $next)
                ->select('id', 'item_id', 'user_id', 'degree', 'date', 'item_token')->get();
            return response(
                $records
            );
        } catch (\Exception $e) {
            return response(array('error' => $e->getMessage(), 'ret' => false));
        }
    }
}
