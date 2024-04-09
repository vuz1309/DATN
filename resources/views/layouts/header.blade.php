 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
  

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url("admin/dashboard")}}" class="brand-link" style="text-align: center;
">
      <span class="brand-text font-weight-light" style="font-weight: 700 !important; font-size: 20px;">Trường học</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('public/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">NTVU</a>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
   
          @if(Auth::user()->user_type == 1)

          <li class="nav-item">
            <a href=" {{url('admin/dashboard')}} " class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tổng quan 
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/admin/list')}}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Danh sách quản lý
              </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="{{url('admin/student/list')}}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Học sinh
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/teacher/list')}}" class="nav-link @if(Request::segment(2) == 'teacher') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Giáo viên
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/parent/list')}}" class="nav-link @if(Request::segment(2) == 'parent') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Phụ huynh
              </p>
            </a>
          </li>
         
          <li class="nav-item menu-is-opening menu-open">
            <a href="#" class="nav-link @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject' || Request::segment(2) == 'assign_class_teacher' || Request::segment(2) == 'class_timeable') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p> 
                Trường học
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <li class="nav-item">
                <a href="{{url('admin/class/list')}}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Lớp học
                  </p>
                </a>
              </li>
    
              <li class="nav-item">
                <a href="{{url('admin/subject/list')}}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Môn học
                  </p>
                </a>
              </li>
             
              <li class="nav-item">
                <a href="{{url('admin/assign_subject/list')}}" class="nav-link @if(Request::segment(2) == 'assign_subject') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Lớp học - môn học
                  </p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{url('admin/assign_class_teacher/list')}}" class="nav-link @if(Request::segment(2) == 'assign_class_teacher') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Giáo viên - Lớp học
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/class_timeable/list')}}" class="nav-link @if(Request::segment(2) == 'class_timeable') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Thời khóa biểu
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'examinations') menu-is-opening menu-open @endif">
            <a href="#" class="nav-link @if(Request::segment(2) == 'examinations') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p> 
                Thi cử
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="display: block;">
              <li class="nav-item">
                <a href="{{url('admin/examinations/exam/list')}}" class="nav-link @if(Request::segment(2) == 'exam') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Bài thi
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('admin/examinations/exam_schedule')}}" class="nav-link @if(Request::segment(2) == 'exam_schedule') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Lịch trình
                  </p>
                </a>
              </li>
    
              <li class="nav-item">
                <a href="{{url('admin/examinations/marks_register')}}" class="nav-link @if(Request::segment(2) == 'marks_register') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Điểm
                  </p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Tài khoản
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Đổi mật khẩu
              </p>
            </a>
          </li>

          



          @elseif(Auth::user()->user_type == 2)
          <li class="nav-item">
            <a href=" {{url('teacher/dashboard')}} " class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Tổng quan
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/my_exam_schedule')}}" class="nav-link @if(Request::segment(2) == 'my_exam_schedule') active @endif">
              <i class="nav-icon far fa-tachometer-alt"></i>
              <p>
                Lịch thi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/calendar')}}" class="nav-link @if(Request::segment(2) == 'calendar') active @endif">
              <i class="nav-icon far fa-tachometer-alt"></i>
              <p>
                Lịch dạy
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/my_class_subject')}}" class="nav-link @if(Request::segment(2) == 'my_class_subject') active @endif">
              <i class="nav-icon far fa-tachometer-alt"></i>
              <p>
                Môn học - lớp
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/my_student')}}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
              <i class="nav-icon far fa-tachometer-alt"></i>
              <p>
                Học sinh
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Tài khoản
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('teacher/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Đổi mật khẩu
              </p>
            </a>
          </li>
          @elseif(Auth::user()->user_type == 3)
          <li class="nav-item">
            <a href=" {{url('student/dashboard')}} " class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Tổng quan
                
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="{{url('student/my_timeable')}}" class="nav-link @if(Request::segment(2) == 'my_timeable') active @endif">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Thời khóa biểu
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_exam_schedule')}}" class="nav-link @if(Request::segment(2) == 'my_exam_schedule') active @endif">
              <i class="far fa-circle nav-icon"></i>
              <p>
                Lịch thi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_calendar')}}" class="nav-link @if(Request::segment(2) == 'my_calendar') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Lịch học
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_subject')}}" class="nav-link @if(Request::segment(2) == 'my_subject') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Môn học
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('student/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Tài khoản
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Đổi mật khẩu
              </p>
            </a>
          </li>
          @elseif(Auth::user()->user_type == 4)
          <li class="nav-item">
            <a href=" {{url('parent/dashboard')}} " class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Tổng quan
                
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('parent/my_student')}}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Con cái
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('parent/account')}}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Tài khoản
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('parent/change_password')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon far fa-user"></i>
              <p>
                Đổi mật khẩu
              </p>
            </a>
          </li>
          @endif
          
          
          <li class="nav-item">
            <a href="{{url('logout')}}" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                Đăng xuất
              </p>
            </a>
          </li>
     
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>