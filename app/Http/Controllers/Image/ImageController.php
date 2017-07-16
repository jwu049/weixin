<?php

namespace App\Http\Controllers\Image;

use App\Http\Util\ApiOutputTool;
use App\Http\Util\ImageErrorInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Util\ImageUtil;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * 上传图片
     * @param Request $request
     */
    public function save(Request $request)
    {
        $request_time = time();
        $file = $request->file('image');

        if (!$file || !$file->isValid()) {
            ApiOutputTool::outputError(
                ImageErrorInfo::UPLOAD_FAILURE,
                ImageErrorInfo::getErrorMsg(ImageErrorInfo::UPLOAD_FAILURE)
            );
        }

        if (!in_array($file->extension(), ImageUtil::getAllowedImageTypes())) {
            ApiOutputTool::outputError(
                ImageErrorInfo::TYPE_NOT_MATCH,
                ImageErrorInfo::getErrorMsg(ImageErrorInfo::TYPE_NOT_MATCH)
            );
        }

        //获取文件名
        $file_name = $file->getClientOriginalName();
        //将文件存在album目录中，并重命名为上传文件的原始名
        $path = $file->storeAs('public', $file_name);
        if (!$path) {
            ApiOutputTool::outputError(
                ImageErrorInfo::SAVE_FAILURE,
                ImageErrorInfo::getErrorMsg(ImageErrorInfo::SAVE_FAILURE)
            );
        }
        $image_url = asset('storage/'.$file_name);
        $data = ['imageUrl' => $image_url];
        ApiOutputTool::outputData($data, '', $request_time);
    }

    /**
     * 删除图片
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $path = $request->file();
    }

    /**
     * 获取图片列表
     */
    public function imageList()
    {
        $request_time = time();
        $files = Storage::files('public');
        if (empty($files)) {
            ApiOutputTool::outputData([], '', $request_time);
        }
        $file_urls = [];
        foreach ($files as $file) {
            $file_name = ImageUtil::getImageName($file);
            $file_extension = ImageUtil::getImageExtension($file_name);
            if (!in_array($file_extension, ImageUtil::getAllowedImageTypes())) {
                continue;
            }
            $file_url = asset('storage/' . $file_name);
            $file_urls[] = $file_url;
        }

        ApiOutputTool::outputData($file_urls, '', $request_time);
    }
}
