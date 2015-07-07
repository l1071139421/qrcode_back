<?php
namespace App\Http\Controllers;

use App\Item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;
use Auth;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }

        $name = $request->input('name');
        $item = Item::firstOrCreate(array('name' => $name));
        return response(
            array(
                'id' => $item->id,
                'name' => $item->name,
            )
        );
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }
        $id = $request->input('id');
        $name = $request->input('name');
        Item::where('id', '=', $id)->update(['name' => $name]);
        try {
            $item = Item::where('id', '=', $id)->firstOrFail();
            return response(
                array(
                    'id' => $item->id,
                    'name' => $item->name,
                )
            );
        } catch (\Exception $e) {
            return response(array('ret' => false));
        }
    }

    public function delete(Request $request)
    {
        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }
        $id = $request->input('id');
        Item::find($id)->delete();

        try {
            $item = Item::where('id', '=', $id)->firstOrFail();
            if (count($item) == 0) {
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

    public function get(Request $request, $id = null)
    {
        if (!Auth::check()) {
            return response(array('error' => 'user not auth', 'ret' => false));
        }
        try {
            if ($id) {
                $item = Item::find($id);
                return response(
                    array(
                        'id' => $item->id,
                        'name' => $item->name,
                    )
                );
            } else {
                $items = DB::table('item')->select('id', 'name')->get();;
                return response(
                    $items
                );
            }
        } catch (\Exception $e) {
            return response(array('ret' => false));
        }
    }
}
