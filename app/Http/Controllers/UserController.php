<?php

namespace App\Http\Controllers;

use App\UserModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){
        try {
            $key = 'data-user';
            $getCaches = getCache($key);

            if ($getCaches != null) {
                return responses($getCaches, null);
            }

            $users = UserModel::select([
                'id',
                'nama',
                'tgl_lahir',
                'alamat',
                'email',
                'created_at',
                'updated_at'])
                ->where('deleted_at', null)
                ->get();
                        
            setCache($key, $users);
            // $users['message'] = 'Success get data!';
            return responses($users, null);
        }
        catch(QueryException $e) {
            return errorQuery($e);
        }

        return responses($users, null);
    }

    public function getUser($id){
        try {
            $key = 'data-user-'.$id;
            $getCaches = getCache($key);

            if ($getCaches != null) {
                return responses($getCaches, 200);
            }

            $users = UserModel::select([
                'id',
                'nama',
                'tgl_lahir',
                'alamat',
                'email',
                'created_at',
                'updated_at'])->where('id', $id)->firstOrFail();

            setCache($key, $users);
            $users['message'] = 'Success get data!';
            return responses($users, null);
        }
        catch(QueryException $e) {
            return errorQuery($e);
        }
        
        return response()->json($get);
    }

    public function store(Request $req){
        try {
            $key = 'data-user';

            $data = new UserModel();
            $data->nama = $req->nama;
            $data->tgl_lahir = $req->tanggal_lahir;
            $data->alamat = $req->alamat;
            $data->email = $req->email;
            $data->save();

            $data->message = 'Data berhasil disimpan!';    
            deleteCache($key);
            return responses($data, null);
        } 
        catch(QueryException $e) {
            return errorQuery($e);
        }

        return response()->json($get);
    }

    public function update(Request $req, $id){
        try {
            $key = 'data-user-'.$id;
            $key2 = 'data-user';
            $data = UserModel::where('id', $id)->firstOrFail();
            $data->updated_at = date("Y-m-d H:i:s");
            $inputdata = $req->all();
            $data->fill($inputdata)->save();
            
            $data->message = 'Data berhasil diupdate!';
            deleteCache($key);
            deleteCache($key2);
            return responses($data, 200);
        }
        catch(QueryException $e) {
            return errorQuery($e);
        }

        return response()->json($get);
    }

    public function destroy(Request $req, $id){
        try {
            $key = 'data-user-'.$id;
            $key2 = 'data-user';
            $data = UserModel::where('id', $id)->firstOrFail();
            $data->updated_at = date("Y-m-d H:i:s");
            $data->deleted_at = date("Y-m-d H:i:s");
            $inputdata = $req->all();
            $data->fill($inputdata)->save();
            
            $data->message = 'Data berhasil dihapus!';
            deleteCache($key);
            deleteCache($key2);
            return responses($data, 200);
        }
        catch(QueryException $e) {
            return errorQuery($e);
        }

        return response()->json($get);
    }
}
