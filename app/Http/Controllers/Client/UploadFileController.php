<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function Sodium\add;
use Storage;

class UploadFileController extends Controller
{
    public function upload(Request $request)
    {
        $res = [
            'success' => false,
            'data' => [],
        ];
        $base64String = $request->input('data');

        $results = $this->saveImgBase64($base64String, 'uploads');

        if ($results != '') {
            $res = [
                'success' => true,
                'data' =>  [
                    'link' => $request->root() . $results
                ]
            ];
        }

        return response()->json($res);
    }

    public function uploadFiles(Request $request){
        $res = [
            'success' => false,
            'data' => [],
        ];

        $files = $request->file();

        $destinationPath = 'uploads';
        $storage = Storage::disk('public');
        $checkDirectory = $storage->exists($destinationPath);

        if (!$checkDirectory) {
            $storage->makeDirectory($destinationPath);
        }
        $urls = array();
        for ($i=0;$i<count($files);$i++){
            $file = $request->file('file'.$i);
            $url = $storage->putFile($destinationPath, $file, 'public');
            if($url){
                $url = Storage::url($url);
                $url = $request->root() . $url;
                array_push($urls,$url);
            }

        }
        if (count($urls) > 0) {
            $res = [
                'success' => true,
                'data' =>  [
                    'link' => $urls
                ]
            ];
        }

        return response()->json($res);
    }

    public function uploadImages(Request $request){
        $res = [
            'success' => false,
            'data' => [],
        ];

        $files = $request->file();

        $destinationPath = 'uploads';
        $storage = Storage::disk('public');
        $checkDirectory = $storage->exists($destinationPath);

        if (!$checkDirectory) {
            $storage->makeDirectory($destinationPath);
        }
        $urls = array();
        for ($i=0;$i<count($files);$i++){
            $file = $request->file('photo'.$i);
            $url = $storage->putFile($destinationPath, $file, 'public');
            if($url){
                $url = Storage::url($url);
                $url = $request->root() . $url;
                array_push($urls,$url);
            }

        }
        if (count($urls) > 0) {
            $res = [
                'success' => true,
                'data' =>  [
                    'link' => $urls
                ]
            ];
        }

        return response()->json($res);

    }

    protected function saveImgBase64($param, $folder)
    {
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], 'jpg');

        $content = $param;
        $storage = Storage::disk('public');

        $checkDirectory = $storage->exists($folder);

        if (!$checkDirectory) {
            $storage->makeDirectory($folder);
        }

        $url = '';

        if($storage->put($folder . '/' . $fileName, base64_decode($content), 'public')){
            $url = Storage::url($folder . '/' . $fileName);
        }

        return $url;
    }

}
