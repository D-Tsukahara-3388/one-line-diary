<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show($userId, $fileName)
    {
        // プライベートストレージから画像を取得
        $filePath = "private/images/{$userId}/{$fileName}";
        
        // ファイルが存在するか確認
        if (!Storage::disk('local')->exists($filePath)) {
            abort(404);  // 存在しない場合は404エラー
        }
        
        // ファイルをレスポンスとして返す
        return response()->file(Storage::disk('local')->path($filePath));
    }
}
