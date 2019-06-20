<?php

namespace App\Http\Controllers;

use App\UserModel;
use Illuminate\Http\Request;

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
            $users = UserModel::get();
            $get['Data'] = $users;
        }
        catch(\Exception $e) {
            $get['Message'] = 'Gagal menampilkan data!';
            $get['Detail'] = $e;
        }

        return response()->json($get);
    }

    public function getUser($id){
        try {
            $data = UserModel::where('id', $id)->get();
            $get['Data'] = $data;
        }
        catch(\Exception $e) {
            $get['Message'] = 'Gagal menampilkan data!';
            $get['Detail'] = $e;
        }
        
        return response()->json($get);
    }

    public function store(Request $req){
        try {
            $data = new UserModel();
            $data->nama = $req->input('nama');
            $data->tgl_lahir = $req->input('tanggal_lahir');
            $data->alamat = $req->input('alamat');
            $data->email = $req->input('email');
            $data->save();
            
            $get['Message'] = 'Berhasil menambahkan data!';
            $get['Data'] = $data;
        } 
        catch(\Exception $e) {
            $get['Message'] = 'Gagal menambahkan data!';
            $get['Detail'] = $e;
        }

        return response()->json($get);
    }

    public function update(Request $req, $id){
        try {
            $data = UserModel::where('id', $id)->first();
            $data->nama = $req->input('nama');
            $data->tgl_lahir = $req->input('tanggal_lahir');
            $data->alamat = $req->input('alamat');
            $data->email = $req->input('email');
            $data->save();
            
            $get['Message'] = 'Berhasil mengupdate data!';
            $get['Data'] = $data;
        }
        catch(\Exception $e) {
            $get['Message'] = 'Gagal mengupdate data!';
            $get['Detail'] = $e;
        }

        return response()->json($get);
    }

    public function destroy($id){
        try {
            $data = UserModel::where('id', $id)->first();
            $data->delete();
            $get['Message'] = 'Berhasil menghapus data!';
        }
        catch(\Exception $e) {
            $get['Message'] = 'Gagal menghapus data!';
            $get['Detail'] = $e;
        }

        return response()->json($get);
    }
}
