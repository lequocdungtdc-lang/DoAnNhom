<?php

namespace App\Http\Controllers;

use App\Support\ImageUpload;
use Illuminate\Http\UploadedFile;

/**
 * Lớp cha cho controller cần dùng chung các helper (upload ảnh/file, tiện ích khác…).
 * Kế thừa Controller Laravel; các controller con extends class này.
 */
abstract class BaseApplicationController extends Controller
{
    /**
     * Lưu file ảnh và trả về đường dẫn tương đối trên disk (lưu DB, hiển thị: asset('storage/'.$path)).
     *
     * @param  UploadedFile|null  $file  File từ $request->file('ten_field') hoặc null nếu không upload
     * @param  string  $directory  Thư mục con trong storage/app/public (vd: album_images, avatars)
     * @param  string  $disk  Disk trong config/filesystems.php (thường là 'public')
     * @param  string|null  $oldRelativePath  Xóa file cũ trên cùng disk sau khi lưu thành công (vd: giá trị cột DB cũ)
     * @param  array<int, string>  $allowedExtensions  Phần mở rộng chấp nhận, không phân biệt hoa thường
     */
    protected function setPhoto(
        ?UploadedFile $file,
        string $directory = 'uploads',
        string $disk = 'public',
        ?string $oldRelativePath = null,
        array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'],
    ): ?string {
        return ImageUpload::store($file, $directory, $disk, $oldRelativePath, $allowedExtensions);
    }
}
