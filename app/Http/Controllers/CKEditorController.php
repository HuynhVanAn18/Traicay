<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload/ckeditor'), $filename);
            $url = asset('upload/ckeditor/'.$filename);

            // For CKEditor image dialog
            if ($request->has('CKEditorFuncNum')) {
                $funcNum = $request->input('CKEditorFuncNum');
                $message = '';
                $response = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
                return response($response)->header('Content-Type', 'text/html; charset=utf-8');
            }

            // For drag-drop or other integrations
            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url
            ]);
        }
        // Error response for both dialog and JSON
        if ($request->has('CKEditorFuncNum')) {
            $funcNum = $request->input('CKEditorFuncNum');
            $message = 'No file uploaded.';
            $response = "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '', '$message');</script>";
            return response($response)->header('Content-Type', 'text/html; charset=utf-8');
        }
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'No file uploaded.']]);
    }
}
