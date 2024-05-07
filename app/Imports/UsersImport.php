<?php

namespace App\Imports;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;


class UsersImport implements ToModel, WithValidation, SkipsOnError, SkipsEmptyRows, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        // Lấy ID của lớp học từ tên lớp
        $class = ClassModel::where('name', $row['lop'])->first();

        if ($class) {
            // Tạo một bản ghi User mới với thông tin đã được trích xuất từ tệp Excel
            return new User([
                'name'     => $row['ho'],
                'last_name' => $row['ten'],
                'email'    => $row['email'],
                'password' => Hash::make($row['mat_khau']),
                'admission_number' => $row['ma_hoc_sinh'],
                'class_id' => $class->id, // Sử dụng ID của lớp học tương ứng
                'user_type' => 3
            ]);
        }

        // Nếu không tìm thấy lớp học, có thể xử lý tùy ý, ví dụ như bỏ qua hoặc ghi log lỗi.
        // Trong trường hợp này, tôi sẽ trả về null để bỏ qua việc tạo bản ghi User này.
        return null;
    }

    // public function onFailure(Failure ...$failures)
    // {
    // }

    // public function uniqueBy()
    // {
    //     return ['email', 'admission_number'];
    // }

    public function rules(): array
    {
        return [
            '*.email' => ['email', 'required', 'unique:users,email'],
            '*.ma_hoc_sinh' => ['required', 'unique:users,admission_number'],
            '*.ho' => ['required'],
            '*.ten' => ['required'],
            '*.mat_khau' => ['required'],
            '*.lop' => ['required',  function ($attribute, $value, $fail) {

                if (!ClassModel::where('name', trim($value))->exists()) {
                    $fail('Lớp ' . $value . ' không tồn tại.');
                }
            },],
        ];
    }
    public function customValidationMessages()
    {
        return [
            'email.email' => 'Trường "email" phải là một địa chỉ email.',
            'email.required' => 'Trường "email" không được bỏ trống.',
            'email.unique' => 'Trường "email" đã tồn tại trong hệ thống.',
            'email.string' => 'Trường "email" phải là một chuỗi ký tự.',
            'ma_hoc_sinh.required' => 'Trường "mã học sinh" không được bỏ trống.',
            'ma_hoc_sinh.unique' => 'Trường "mã học sinh" đã tồn tại trong hệ thống.',
            'ma_hoc_sinh.string' => 'Trường "mã học sinh" phải là một chuỗi ký tự.',
            'ho.required' => 'Trường "họ" không được bỏ trống.',
            'ho.string' => 'Trường "họ" phải là một chuỗi ký tự.',
            'ten.required' => 'Trường "tên" không được bỏ trống.',
            'ten.string' => 'Trường "tên" phải là một chuỗi ký tự.',
            'mat_khau.required' => 'Trường "mật khẩu" không được bỏ trống.',
            'mat_khau.string' => 'Trường "mật khẩu" phải là một chuỗi ký tự.',
            'lop.required' => 'Trường "lớp" không được bỏ trống.',
            'lop.string' => 'Trường "lớp" phải là một chuỗi ký tự.',
            'lop.exists' => 'Trường "lớp" không tồn tại.',
        ];
    }
}
