 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                     class=" nav-icon fas fa-bars"></i></a>
         </li>

     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         @php
             $AllChatUserCount = App\Models\ChatModel::getAllChatUserCount();
         @endphp


         <li class="nav-item">
             <a href="{{ url('chat') }}" class="nav-link">
                 <i class=" nav-icon far fa-comments"></i>
                 @if (!empty($AllChatUserCount))
                     <span class="badge badge-danger navbar-badge">{{ $AllChatUserCount }}</span>
                 @endif

             </a>

         </li>

     </ul>
 </nav>
 <!-- /.navbar -->

 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     @php
         $logo = config('app.system_settings.school_logo');
     @endphp
     <div style="display: flex; align-items: center; justify-content: center; padding: 0 12px;">
         @if (!empty($logo))
             <img src="{{ url('upload/settings/' . $logo) }}" style="width: 40px; height: 40px; border-radius: 50%"
                 alt="LOGO">
         @endif
         <a href="#" class="brand-link" style="text-align: center; padding: 12px 0;
   ">
             <span class="brand-text font-weight-light"
                 style="font-weight: 700 !important; font-size: 20px;">{{ config('app.system_settings.school_name') }}</span>
         </a>
     </div>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 @if (auth()->check() && !empty(auth()->user()->profile_pic))
                     <img src="{{ url('upload/profile/' . auth()->user()->profile_pic) }}"
                         class="img-circle elevation-2" alt="User Image">
                 @else
                     <img src="{{ url('upload/profile/default.jpg') }}" class="img-circle elevation-2" alt="User Image">
                 @endif

             </div>
             <div class="info">
                 @if (auth()->check())
                     <a href="#" class="d-block">{{ auth()->user()->name }}
                         {{ auth()->user()->last_name }}</a>
                 @endif
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">

                 @if (Auth::user()->user_type == 1)
                     <li class="nav-item">
                         <a href=" {{ url('admin/dashboard') }} "
                             class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                             <i class=" nav-icon nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Tổng quan

                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('admin/class_transfers/admin_list') }}"
                             class="nav-link @if (Request::segment(2) == 'class_transfers') active @endif">
                             <i class=" nav-icon fas fa-cogs"></i>
                             <p>Yêu cầu chuyển lớp</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('admin/admin/list') }}"
                             class="nav-link @if (Request::segment(2) == 'admin') active @endif">
                             <i class=" nav-icon fas fa-cogs"></i>
                             <p>Danh sách quản lý</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('admin/student/list') }}"
                             class="nav-link @if (Request::segment(2) == 'student') active @endif">
                             <i class=" nav-icon fas fa-user-graduate"></i>
                             <p>Học sinh</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('admin/suspension/list') }}"
                             class="nav-link @if (Request::segment(2) == 'suspension') active @endif">
                             <i class=" nav-icon fas fa-user-slash"></i>
                             <p>Học sinh bảo lưu</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('admin/teacher/list') }}"
                             class="nav-link @if (Request::segment(2) == 'teacher') active @endif">
                             <i class=" nav-icon fas fa-chalkboard-teacher"></i>
                             <p>Giáo viên</p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('admin/parent/list') }}"
                             class="nav-link @if (Request::segment(2) == 'parent') active @endif">
                             <i class=" nav-icon fas fa-user-friends"></i>
                             <p>Phụ huynh</p>
                         </a>
                     </li>

                     <li class="nav-item menu-open">
                         <a href="#" class="nav-link @if (Request::segment(2) == 'class' ||
                                 Request::segment(2) == 'subject' ||
                                 Request::segment(2) == 'assign_subject' ||
                                 Request::segment(2) == 'assign_class_teacher' ||
                                 Request::segment(2) == 'class_timeable') active @endif">
                             <i class=" nav-icon  fas fa-table"></i>
                             <p>
                                 Trường học
                                 <i class=" nav-icon fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview" style="display: block;">
                             <li class="nav-item">
                                 <a href="{{ url('admin/class/list') }}"
                                     class="nav-link @if (Request::segment(2) == 'class') active @endif">
                                     <i class=" nav-icon fas fa-chalkboard-teacher"></i>
                                     <p>Lớp học</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ url('admin/subject/list') }}"
                                     class="nav-link @if (Request::segment(2) == 'subject') active @endif">
                                     <i class=" fas fa-book-open nav-icon"></i>
                                     <p>Khóa học</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ url('admin/assign_subject/list') }}"
                                     class="nav-link @if (Request::segment(2) == 'assign_subject') active @endif">
                                     <i class="  fas fa-school nav-icon"></i>
                                     <p>Lớp học - Khóa học</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ url('admin/assign_class_teacher/list') }}"
                                     class="nav-link @if (Request::segment(2) == 'assign_class_teacher') active @endif">
                                     <i class=" fas fa-user-graduate nav-icon"></i>
                                     <p>Chủ nhiệm</p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ url('admin/class_timeable/list') }}"
                                     class="nav-link @if (Request::segment(2) == 'class_timeable') active @endif">
                                     <i class="far fa-calendar-alt nav-icon"></i>
                                     <p>Thời khóa biểu</p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-item  menu-open">
                         <a href="#" class="nav-link @if (Request::segment(2) == 'fee') active @endif">
                             <i class="  nav-icon fas fa-table"></i>
                             <p>
                                 Học phí
                                 <i class=" nav-icon fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview" style="display: block;">
                             <li class="nav-item">
                                 <a href="{{ url('admin/fee/fee_collect') }}"
                                     class="nav-link @if (Request::segment(3) == 'fee_collect') active @endif">
                                     <i class="  fas fa-hand-holding-usd nav-icon"></i>
                                     <p>Nộp học phí</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ url('admin/fee/fee_collect_report') }}"
                                     class="nav-link @if (Request::segment(3) == 'fee_collect_report') active @endif">
                                     <i class=" far fa-file-alt nav-icon"></i>
                                     <p>Báo cáo</p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-item menu-is-opening menu-open">
                         <a href="#" class="nav-link @if (Request::segment(2) == 'attendance') active @endif">
                             <i class=" nav-icon fas fa-table"></i>
                             <p>
                                 Điểm danh
                                 <i class=" nav-icon fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview" style="display: block;">
                             <li class="nav-item">
                                 <a href="{{ url('admin/attendance/student') }}"
                                     class="nav-link @if (Request::segment(3) == 'student') active @endif">
                                     <i class="fas fa-user-check nav-icon"></i>
                                     <p>Điểm danh học sinh</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ url('admin/attendance/report') }}"
                                     class="nav-link @if (Request::segment(3) == 'report' && Request::segment(2) == 'attendance') active @endif">
                                     <i class="fas fa-file-signature nav-icon"></i>
                                     <p>Báo cáo</p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-item menu-is-opening menu-open">
                         <a href="#" class="nav-link @if (Request::segment(2) == 'examinations') active @endif">
                             <i class="nav-icon fas fa-table"></i>
                             <p>
                                 Học tập
                                 <i class=" nav-icon fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview" style="display: block;">
                             <li class="nav-item">
                                 <a href="{{ url('admin/homework/homework') }}"
                                     class="nav-link @if (Request::segment(3) == 'homework') active @endif">
                                     <i class=" nav-icon fas fa-book nav-icon"></i>
                                     <p>Bài tập</p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ url('admin/homework/report') }}"
                                     class="nav-link @if (Request::segment(3) == 'report' && Request::segment(2) == 'homework') active @endif">
                                     <i class=" nav-icon fas fa-clipboard-list nav-icon"></i>
                                     <p>Báo cáo bài tập</p>
                                 </a>
                             </li>
                             <!-- Các mục khác -->
                             <li class="nav-item">
                                 <a href="{{ url('admin/examinations/exam/list') }}"
                                     class="nav-link @if (Request::segment(3) == 'exam') active @endif">
                                     <i class="far fa-file-alt nav-icon"></i>
                                     <p>
                                         Bài thi
                                     </p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ url('admin/examinations/exam_schedule') }}"
                                     class="nav-link @if (Request::segment(3) == 'exam_schedule') active @endif">
                                     <i class="far fa-calendar-alt nav-icon"></i>
                                     <p>
                                         Lịch trình
                                     </p>
                                 </a>
                             </li>

                             <li class="nav-item">
                                 <a href="{{ url('admin/examinations/marks_register') }}"
                                     class="nav-link @if (Request::segment(3) == 'marks_register') active @endif">
                                     <i class=" far fa-edit nav-icon"></i>
                                     <p>
                                         Điểm
                                     </p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ url('admin/examinations/marks_grade') }}"
                                     class="nav-link @if (Request::segment(3) == 'marks_grade') active @endif">
                                     <i class="far fa-chart-bar nav-icon"></i>
                                     <p>
                                         Thang điểm
                                     </p>
                                 </a>
                             </li>
                         </ul>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('admin/comunicate/send_email') }}"
                             class="nav-link @if (Request::segment(3) == 'send_email') active @endif">
                             <i class=" nav-icon nav-icon fas fa-envelope"></i>
                             <p>Gửi thông báo</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('admin/account') }}"
                             class="nav-link @if (Request::segment(2) == 'account') active @endif">
                             <i class=" nav-icon nav-icon far fa-user"></i>
                             <p>Tài khoản</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('admin/change_password') }}"
                             class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                             <i class=" nav-icon nav-icon fas fa-key"></i>
                             <p>Đổi mật khẩu</p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('admin/settings') }}"
                             class="nav-link @if (Request::segment(2) == 'settings') active @endif">
                             <i class=" nav-icon nav-icon fas fa-cog"></i>
                             <p>Cài đặt</p>
                         </a>
                     </li>
                 @elseif(Auth::user()->user_type == 2)
                     <li class="nav-item">
                         <a href=" {{ url('teacher/dashboard') }} "
                             class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                             <i class=" nav-icon nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Tổng quan

                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/my_exam_schedule') }}"
                             class="nav-link @if (Request::segment(2) == 'my_exam_schedule') active @endif">
                             <i class=" nav-icon far fa-calendar-alt"></i>
                             <p>
                                 Lịch thi
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/calendar') }}"
                             class="nav-link @if (Request::segment(2) == 'calendar') active @endif">
                             <i class=" nav-icon far fa-calendar-alt"></i>
                             <p>
                                 Lịch dạy
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/homework/homework') }}"
                             class="nav-link @if (Request::segment(2) == 'homework') active @endif">
                             <i class=" nav-icon far fa-clipboard"></i>
                             <p>
                                 Bài tập
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/marks_register') }}"
                             class="nav-link @if (Request::segment(2) == 'marks_register') active @endif">
                             <i class=" nav-icon far fa-edit"></i>
                             <p>
                                 Điểm
                             </p>
                         </a>
                     </li>
                     <li class="nav-item  menu-is-opening menu-open ">
                         <a href="#" class="nav-link @if (Request::segment(2) == 'attendance') active @endif">
                             <i class=" nav-icon fas fa-table"></i>
                             <p>
                                 Điểm danh
                                 <i class=" nav-icon fas fa-angle-left right"></i>
                             </p>
                         </a>
                         <ul class="nav nav-treeview" style="display: block;">
                             <li class="nav-item">
                                 <a href="{{ url('teacher/attendance/student') }}"
                                     class="nav-link @if (Request::segment(3) == 'student') active @endif">
                                     <i class=" nav-icon far fa-circle"></i>
                                     <p>
                                         Điểm danh học sinh
                                     </p>
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ url('teacher/attendance/report') }}"
                                     class="nav-link @if (Request::segment(3) == 'report') active @endif">
                                     <i class=" nav-icon far fa-circle"></i>
                                     <p>
                                         Báo cáo
                                     </p>
                                 </a>
                             </li>
                         </ul>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/my_class_subject') }}"
                             class="nav-link @if (Request::segment(2) == 'my_class_subject') active @endif">
                             <i class=" nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Khóa học - lớp
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/my_student') }}"
                             class="nav-link @if (Request::segment(2) == 'my_student') active @endif">
                             <i class=" nav-icon fas fa-user-graduate"></i>
                             <p>
                                 Học sinh
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('teacher/account') }}"
                             class="nav-link @if (Request::segment(2) == 'account') active @endif">
                             <i class=" nav-icon  far fa-user"></i>
                             <p>
                                 Tài khoản
                             </p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('teacher/change_password') }}"
                             class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                             <i class=" nav-icon fas fa-lock"></i>
                             <p>
                                 Đổi mật khẩu
                             </p>
                         </a>
                     </li>
                 @elseif(Auth::user()->user_type == 3)
                     <li class="nav-item">
                         <a href=" {{ url('student/dashboard') }} "
                             class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                             <i class=" nav-icon nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Tổng quan

                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/my_timeable') }}"
                             class="nav-link @if (Request::segment(2) == 'my_timeable') active @endif">
                             <i class=" nav-icon far fa-calendar-alt"></i>
                             <p>
                                 Thời khóa biểu
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/my_homework') }}"
                             class="nav-link @if (Request::segment(2) == 'my_homework') active @endif">
                             <i class=" nav-icon far fa-clipboard"></i>
                             <p>
                                 Bài tập
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/homework/submitted') }}"
                             class="nav-link @if (Request::segment(3) == 'submitted') active @endif">
                             <i class=" nav-icon far fa-check-circle"></i>
                             <p>
                                 Bài tập đã nộp
                             </p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('student/my_exam_schedule') }}"
                             class="nav-link @if (Request::segment(2) == 'my_exam_schedule') active @endif">
                             <i class=" nav-icon far fa-calendar-check"></i>
                             <p>
                                 Lịch thi
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/my_attendance_report') }}"
                             class="nav-link @if (Request::segment(2) == 'my_attendance_report') active @endif">
                             <i class=" nav-icon far fa-address-book"></i>
                             <p>
                                 Điểm danh
                             </p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('student/my_calendar') }}"
                             class="nav-link @if (Request::segment(2) == 'my_calendar') active @endif">
                             <i class=" nav-icon far fa-calendar"></i>
                             <p>
                                 Lịch học
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/my_exam_result') }}"
                             class="nav-link @if (Request::segment(2) == 'my_exam_result') active @endif">
                             <i class=" nav-icon far fa-edit"></i>
                             <p>
                                 Điểm
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/my_class') }}"
                             class="nav-link @if (Request::segment(2) == 'my_subject') active @endif">
                             <i class=" nav-icon fa fa-book-open"></i>
                             <p>
                                 Lớp học của tôi
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/fee_collect') }}"
                             class="nav-link @if (Request::segment(2) == 'fee_collect') active @endif">
                             <i class=" nav-icon far fa-money-bill-alt"></i>
                             <p>
                                 Nộp học phí
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/move') }}"
                             class="nav-link @if (Request::segment(2) == 'move') active @endif">
                             <i class=" nav-icon far fa-money-bill-alt"></i>
                             <p>
                                 Chuyển lớp
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/suspension/list') }}"
                             class="nav-link @if (Request::segment(2) == 'suspension') active @endif">
                             <i class=" nav-icon far fa-money-bill-alt"></i>
                             <p>
                                 Bảo lưu
                             </p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('student/account') }}"
                             class="nav-link @if (Request::segment(2) == 'account') active @endif">
                             <i class=" nav-icon far fa-user"></i>
                             <p>
                                 Tài khoản
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('student/change_password') }}"
                             class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                             <i class=" nav-icon fas fa-lock"></i>
                             <p>
                                 Đổi mật khẩu
                             </p>
                         </a>
                     </li>
                 @elseif(Auth::user()->user_type == 4)
                     <li class="nav-item">
                         <a href=" {{ url('parent/dashboard') }} "
                             class="nav-link @if (Request::segment(2) == 'dashboard') active @endif">
                             <i class=" nav-icon nav-icon fas fa-tachometer-alt"></i>
                             <p>
                                 Tổng quan

                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('parent/my_student') }}"
                             class="nav-link @if (Request::segment(2) == 'my_student') active @endif">
                             <i class=" nav-icon nav-icon fas fa-child"></i>
                             <p>
                                 Con cái
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('parent/my_attendance_report') }}"
                             class="nav-link @if (Request::segment(2) == 'my_attendance_report') active @endif">
                             <i class=" nav-icon nav-icon far fa-calendar-check"></i>
                             <p>
                                 Thông tin điểm danh
                             </p>
                         </a>
                     </li>

                     <li class="nav-item">
                         <a href="{{ url('parent/account') }}"
                             class="nav-link @if (Request::segment(2) == 'account') active @endif">
                             <i class=" nav-icon far fa-user"></i>
                             <p>
                                 Tài khoản
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ url('parent/change_password') }}"
                             class="nav-link @if (Request::segment(2) == 'change_password') active @endif">
                             <i class=" nav-icon nav-icon fas fa-lock"></i>
                             <p>
                                 Đổi mật khẩu
                             </p>
                         </a>
                     </li>
                 @endif


                 <li class="nav-item">
                     <a href="{{ url('logout') }}" class="nav-link">
                         <i class=" nav-icon fas fa-sign-out-alt"></i>
                         <p>
                             Đăng xuất
                         </p>
                     </a>
                 </li>



             </ul>
         </nav>

     </div>

 </aside>
