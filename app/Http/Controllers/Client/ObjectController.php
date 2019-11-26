<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class ObjectController extends Controller
{
    protected $table;
    protected $values = array();
    protected $update_key = "id";

    public function get($key, $operator = null, $value = null, $column = null)
    {
        if ($column == null) {
            //get all columns
            return DB::table($this->table)->where($key, $operator, $value)->get();
        } else if (count($column) > 0) {
            return DB::table($this->table)->where($key, $operator, $value)->get($column);
        }

        return [];
    }

    public function create()
    {
        return $this->queryTable('create');
    }

    public function createGetId()
    {
        return $this->queryTable('create_get_id');
    }

    public function update()
    {
        return $this->queryTable('update');
    }

    public function delete()
    {
        $id = Input::get("id");
        if(DB::table($this->table)->delete([$id]))
            responseSuccess("Deleted");
        responseFail("Delete failed");
    }

    protected function queryTable($query)
    {
        try {
            switch ($query) {
                case 'create':
                    DB::table($this->table)->insert($this->values);
                    break;
                case 'create_get_id':
                    $id = DB::table($this->table)->insertGetId($this->values);
                    return $id;
                case 'update':
                    if ($this->values[$this->update_key] != null) {
                        if (!isset($this->values['created_at']))
                            unset($this->values['created_at']);
                        if (!DB::table($this->table)->where($this->update_key, $this->values[$this->update_key])->update($this->values))
                            return responseFail('Update fail');
                    }
                    break;
                case "updateOrInsert":
                    DB::table($this->table)->updateOrInsert($this->values);
                    break;
                case 'delete':
                    break;
                default:
                    break;
            }
            return responseSuccess();
        } catch (QueryException $exception) {
            return responseFail($exception);
        }
    }
}
