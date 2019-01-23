<?php
namespace App\Handlers;
use Image;

class ImageUploadHandlers
{
    // 允许上传图片的后缀
    protected $allowd_ext = ['jpeg', 'jpg', 'gif', 'png'];

    /**
     * 图片保存并且裁剪操作
     * @param $file 上传的文件信息
     * @param $folder 成生的图片目录名称
     * @param $file_prefix 生成图片的前缀
     * @param $max_width 限制图片最大尺寸
     */
    public function save($file, $folder, $file_prefix, $max_width)
    {
        // 获取图片的后缀名
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 判断上传的文件是否是图片
        if (!in_array($extension, $this->allowd_ext)) {
            return false;
        }

        // 构建目录成生规则 uploads/images/avatars/201901/12
        $file_path = 'uploads/images/' . $folder . '/' . date('Ym/d', time());

        // 拼接物理路径
        $upload_path = public_path() . '/' . $file_path;

        // 拼接图片名称 1_123454543543_sdfsfsdsdf.png
        $filename = $file_prefix . '_' . time() . '_' . str_random(10) . '.' . $extension;

        // 将图片移动到指定位置
        $file->move($upload_path, $filename);

        if ($max_width && $extension != 'gif') {
            $this->reduceSize($upload_path . '/' . $filename, $max_width);
        }

        // 返回生成的图片路径
        return [
            'path' => config('app.url') . '/' . $file_path . '/' . $filename
        ];
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}