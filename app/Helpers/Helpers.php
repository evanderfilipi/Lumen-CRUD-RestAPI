<?php

if (!function_exists('responses')) {

    function responses($data, $status) {
        $results = [];
        // $datas = collect($data);
        // print_r($data); die;

        if($status == null) {
            $results['error'] = false;
            $results['code'] = 200;
        } else {
            $results['error'] = true;
            $results['code'] = $status;
        }

        if(isset($data['message']) == false){
            $results['message'] = "Success get data!";
        } else {
            $results['message'] = $data['message'];
        }
        $results['result'] = [];
        $datas = json_decode($data);

        if(is_array($datas) == true) {
            $total = count($datas);
            $results['result']['num_found'] = $total;
            $results['result']['start_index'] = 0;
            $results['result']['end_index'] = $total - 1;
            $results['result']['row'] = $datas;
        } else {
            // $datas = array($datas);
            $results['result'] = $datas;
            unset($results['result']->message);
        }

        return response()->json($results)->setStatusCode($results['code']);
    }
}

if (!function_exists('errorCustomStatus')) {

    function errorCustomStatus($status, $message) {
        // $results = [];
        $results['code'] = $status;
        switch($status) {
            case 404:
                $results['message'] = "Halaman yang dituju tidak ditemukan!";
            case 403:
                $results['message'] = "Anda tidak memiliki izin untuk mengakses halaman ini!";
            case 408:
                $results['message'] = "Waktu memuat server telah habis!";
            case 422:
                $results['message'] = "Terjadi kesalahan dalam menginput data. Silahkan anda cek kembali!";
            case 504:
                $results['message'] = "Server sedang sibuk!";
            case 503:
                $results['message'] = "Layanan serve tidak tersedia untuk saat ini!";
            default:
                $results = $message;
        }

        return response()->json($results);
    }
}

if (!function_exists('errorQuery')) {

    function errorQuery($message) {
        $results['status'] = 500;
        $results['message'] = $message;

        return response()->json($results)->setStatusCode(500);
    }
}

//REDIS
if (!function_exists('getCache')) {

    function getCache($key) {
        if(app('redis')->get($key) != null) {
            $data = app('redis')->get($key);
            // $data = json_decode($data, true);
            return $data;
        }
    }
}

if (!function_exists('setCache')) {

    function setCache($key, $data) {
        app('redis')->set($key, $data);
        app('redis')->expire($key, 600);
    }
}

if (!function_exists('deleteCache')) {

    function deleteCache($key) {
        app('redis')->del($key);
    }
}