<?php

return [
   /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

   'accepted' => 'Trường :attribute phải được chấp nhận.',
   'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
   'after' => 'Trường :attribute phải là một ngày sau :date.',
   'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng :date.',
   'alpha' => 'Trường :attribute chỉ có thể chứa các chữ cái.',
   'alpha_dash' => 'Trường :attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và dấu gạch dưới.',
   'alpha_num' => 'Trường :attribute chỉ có thể chứa chữ cái và số.',
   'array' => 'Trường :attribute phải là một mảng.',
   'before' => 'Trường :attribute phải là một ngày trước :date.',
   'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng :date.',
   'between' => [
      'numeric' => 'Trường :attribute phải nằm trong khoảng :min và :max.',
      'file' => 'Trường :attribute phải nằm trong khoảng :min và :max kilobytes.',
      'string' => 'Trường :attribute phải nằm trong khoảng :min và :max ký tự.',
      'array' => 'Trường :attribute phải có từ :min đến :max phần tử.',
   ],
   'boolean' => 'Trường :attribute phải là true hoặc false.',
   'confirmed' => 'Xác nhận trường :attribute không khớp.',
   'date' => 'Trường :attribute không phải là một ngày hợp lệ.',
   'date_equals' => 'Trường :attribute phải là một ngày bằng :date.',
   'date_format' => 'Trường :attribute không khớp với định dạng :format.',
   'different' => 'Trường :attribute và :other phải khác nhau.',
   'digits' => 'Trường :attribute phải có :digits chữ số.',
   'digits_between' => 'Trường :attribute phải có từ :min đến :max chữ số.',
   'dimensions' => 'Trường :attribute có kích thước hình ảnh không hợp lệ.',
   'distinct' => 'Trường :attribute có giá trị trùng lặp.',
   'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
   'ends_with' => 'Trường :attribute phải kết thúc bằng một trong những giá trị sau: :values.',
   'exists' => 'Giá trị được chọn trong trường :attribute không hợp lệ.',
   'file' => 'Trường :attribute phải là một tệp.',
   'filled' => 'Trường :attribute phải có giá trị.',
   'gt' => [
      'numeric' => 'Trường :attribute phải lớn hơn :value.',
      'file' => 'Trường :attribute phải lớn hơn :value kilobytes.',
      'string' => 'Trường :attribute phải có nhiều hơn :value ký tự.',
      'array' => 'Trường :attribute phải có nhiều hơn :value phần tử.',
   ],
   'gte' => [
      'numeric' => 'Trường :attribute phải lớn hơn hoặc bằng :value.',
      'file' => 'Trường :attribute phải lớn hơn hoặc bằng :value kilobytes.',
      'string' => 'Trường :attribute phải có ít nhất :value ký tự.',
      'array' => 'Trường :attribute phải có ít nhất :value phần tử.',
   ],
   'image' => 'Trường :attribute phải là một hình ảnh.',
   'in' => 'Giá trị được chọn trong trường :attribute không hợp lệ.',
   'in_array' => 'Trường :attribute không tồn tại trong :other.',
   'integer' => 'Trường :attribute phải là một số nguyên.',
   'ip' => 'Trường :attribute phải là một địa chỉ IP hợp lệ.',
   'ipv4' => 'Trường :attribute phải là một địa chỉ IPv4 hợp lệ.',
   'ipv6' => 'Trường :attribute phải là một địa chỉ IPv6 hợp lệ.',
   'json' => 'Trường :attribute phải là một chuỗi JSON hợp lệ.',
   'lt' => [
      'numeric' => 'Trường :attribute phải nhỏ hơn :value.',
      'file' => 'Trường :attribute phải nhỏ hơn :value kilobytes.',
      'string' => 'Trường :attribute phải có ít hơn :value ký tự.',
      'array' => 'Trường :attribute phải có ít hơn :value phần tử.',
   ],
   'lte' => [
      'numeric' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value.',
      'file' => 'Trường :attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
      'string' => 'Trường :attribute phải có tối đa :value ký tự.',
      'array' => 'Trường :attribute không được có nhiều hơn :value phần tử.',
   ],
   'max' => [
      'numeric' => 'Trường :attribute không được lớn hơn :max.',
      'file' => 'Trường :attribute không được lớn hơn :max kilobytes.',
      'string' => 'Trường :attribute không được có nhiều hơn :max ký tự.',
      'array' => 'Trường :attribute không được có nhiều hơn :max phần tử.',
   ],
   'mimes' => 'Trường :attribute phải là một tệp có định dạng: :values.',
   'mimetypes' => 'Trường :attribute phải là một tệp có định dạng: :values.',
   'min' => [
      'numeric' => 'Trường :attribute phải có ít nhất :min.',
      'file' => 'Trường :attribute phải có ít nhất :min kilobytes.',
      'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
      'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
   ],
   'not_in' => 'Giá trị được chọn trong trường :attribute không hợp lệ.',
   'not_regex' => 'Định dạng trường :attribute không hợp lệ.',
   'numeric' => 'Trường :attribute phải là một số.',
   'password' => 'Mật khẩu không đúng.',
   'present' => 'Trường :attribute phải được cung cấp.',
   'regex' => 'Định dạng trường :attribute không hợp lệ.',
   'required' => 'Trường :attribute là bắt buộc.',
   'required_if' => 'Trường :attribute là bắt buộc khi :other là :value.',
   'required_unless' => 'Trường :attribute là bắt buộc trừ khi :other là :values.',
   'required_with' => 'Trường :attribute là bắt buộc khi :values được cung cấp.',
   'required_with_all' => 'Trường :attribute là bắt buộc khi tất cả :values được cung cấp.',
   'required_without' => 'Trường :attribute là bắt buộc khi :values không được cung cấp.',
   'required_without_all' => 'Trường :attribute là bắt buộc khi không có :values nào được cung cấp.',
   'same' => 'Trường :attribute và :other phải khớp nhau.',
   'size' => [
      'numeric' => 'Trường :attribute phải bằng :size.',
      'file' => 'Trường :attribute phải bằng :size kilobytes.',
      'string' => 'Trường :attribute phải có :size ký tự.',
      'array' => 'Trường :attribute phải chứa :size phần tử.',
   ],
   'starts_with' => 'Trường :attribute phải bắt đầu bằng một trong những giá trị sau: :values.',
   'string' => 'Trường :attribute phải là một chuỗi.',
   'timezone' => 'Trường :attribute phải là một múi giờ hợp lệ.',
   'unique' => 'Trường :attribute đã được sử dụng.',
   'uploaded' => 'Tải lên trường :attribute thất bại.',
   'url' => 'Định dạng trường :attribute không hợp lệ.',
   'uuid' => 'Trường :attribute phải là một UUID hợp lệ.',

   /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "rule.attribute" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

   'custom' => [
      'attribute-name' => [
         'rule-name' => 'custom-message',
      ],
   ],

   /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

   'attributes' => [
      'name' => 'tên',
      'username' => 'tên đăng nhập',
      'email' => 'địa chỉ email',
      'first_name' => 'tên',
      'last_name' => 'họ',
      'password' => 'mật khẩu',
      'password_confirmation' => 'xác nhận mật khẩu',
      'city' => 'thành phố',
      'country' => 'quốc gia',
      'address' => 'địa chỉ',
      'phone' => 'số điện thoại',
      'mobile' => 'di động',
      'age' => 'tuổi',
      'sex' => 'giới tính',
      'gender' => 'giới tính',
      'day' => 'ngày',
      'month' => 'tháng',
      'year' => 'năm',
      'hour' => 'giờ',
      'minute' => 'phút',
      'second' => 'giây',
      'title' => 'tiêu đề',
      'content' => 'nội dung',
      'description' => 'mô tả',
      'excerpt' => 'tóm tắt',
      'date' => 'ngày',
      'time' => 'thời gian',
      'available' => 'có sẵn',
      'size' => 'kích thước',
      'image' => 'hình ảnh',
      'file' => 'tệp tin',
      'old_password' => 'mật khẩu cũ',
      'new_password' => 'mật khẩu mới',
      'customerName' => 'tên khách hàng',
      'utype' => 'loại người dùng',
   ],

];
