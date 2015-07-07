<?php
namespace App\Http\Controllers;

use App\Itemdata;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use DB;

class ItemDataController extends Controller
{
    public function create(Request $request)
    {
        
        $data = array(
            'item_id' => $request->input('item_id'),
            'token' =>  $request->input('item_token'),
            'property_num' =>  $request->input('property_num'),
            'address' => $request->input('address'),
        );
        try {
            $item = Itemdata::firstOrCreate($data);
            return response(
                array(
                    'id' => $item->id,
                    'item_id' => $item->item_id,
                    'token' => $item->token,
                    'property_num' => $item->property_num,
                    'address' => $item->address,
                )
            );
        } catch (\Exception $e) {
            return response(array('ret' => false, 'error' => $e->getMessage()));
        }
    }

    public function update(Request $request)
    {
        $data = array(
            'id' => $request->input('id'),
            'item_id' => $request->input('item_id'),
            'token' =>  $request->input('item_token'),
            'property_num' =>  $request->input('property_num'),
            'address' => $request->input('address'),
        );

        $record = Itemdata::find($data['id']);
        foreach ($data as $k => $v) {
            if ($v == null) {
                $data[$k] = $record[$k];
            }
        }
        Itemdata::where('id', '=', $data['id'])->update($data);
        try {
            $item = Itemdata::where('id', '=', $data['id'])->firstOrFail();
            return response(
                array(
                    'id' => $item->id,
                    'item_id' => $item->item_id,
                    'token' => $item->token,
                    'property_num' => $item->property_num,
                    'address' => $item->address,
                )
            );
        } catch (\Exception $e) {
            return response(array('ret' => false, 'error' => $e->getMessage()));
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');

        try {
            Itemdata::find($id)->delete();
            $item = Itemdata::where('id', '=', $id)->firstOrFail();
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
        $item_token = $request->input('item_token');
        try {
            $item = Itemdata::where('token', '=', $item_token)->firstOrFail();
            return response(array('ret' => true));
        } catch (\Exception $e) {
            return response(array('ret' => false));
        }
    }

    public function get(Request $request, $id = null)
    {
        try {
            if ($id) {
                $item = Itemdata::find($id);
                return response(
                    array(
                        'id' => $item->id,
                        'item_id' => $item->item_id,
                        'token' => $item->token,
                        'property_num' => $item->property_num,
                        'address' => $item->address,
                    )
                );
            } else {
                $items = DB::table('itemdata')->join('item', 'item.id', '=', 'itemdata.item_id')->select('itemdata.id', 'item_id', 'item.name', 'token', 'property_num', 'address')->get();
                return response(
                    $items
                );
            }
        } catch (\Exception $e) {
            return response(array('ret' => false, 'error' => $e->getMessage()));
        }
    }

    public function item(Request $request, $id)
    {
        try {
            $items = Itemdata::where('item_id', '=', $id)->get()->toArray();
            return response(
                $items
            );
        } catch (\Exception $e) {
            return response(array('ret' => false, 'error' => $e->getMessage()));
        } 
    }
}
