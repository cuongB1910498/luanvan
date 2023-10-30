<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href={{asset('/public/backend/css/bootstrap.min.css')}} />
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href={{asset('/public/backend/css/dataTables.bootstrap5.min.css')}} />
    <link rel="stylesheet" href={{asset('/public/backend/css/style.css')}} />

    {{-- databasejs css --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" /> --}}
    

    <title>THYN Express Admin</title>
  </head>
  <body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample"
        >
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-0 ms-3 text-uppercase fw-bold"
          href="{{URL::to('/admin-dashboard')}}"
          >Thyn Express</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
          <form class="d-flex ms-auto my-3 my-lg-0">
            <div class="input-group">
              <input
                class="form-control"
                type="search"
                placeholder="Search"
                aria-label="Search"
              />
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Setting</a></li>
                <li>
                  <a class="dropdown-item" href="{{URL::to('/admin-logout')}}">Log-out</a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div
      class="offcanvas offcanvas-start sidebar-nav bg-dark"
      tabindex="-1"
      id="sidebar"
    >
      <div class="offcanvas-body p-0">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
           
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                QL Thành Phần
              </div>
            </li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
              >
                <span class="me-2"><i class="bi bi-layout-split"></i></span>
                <span>QL Chức Vụ</span>
                
              </a>
              
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="{{URL::to('/add-posision')}}" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-plus-lg"></i></span>
                      <span>Chức vụ mới</span>
                    </a>
                  </li>

                  <li>
                    <a href="{{URL::to('/posision-list')}}" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-list-check"></i></span>
                      <span>Danh sách chứ vụ</span>
                    </a>
                  </li>
                </ul>
              
              
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
                <a
                  class="nav-link px-3 sidebar-link"
                  data-bs-toggle="collapse"
                  href="#layouts1"
                >
                  <span class="me-2"><i class="bi bi-house"></i></span>
                  <span>QL Trạm</span>
                 
                </a>
                
                  <ul class="navbar-nav ps-3">
                    <li>
                      <a href="{{URL::to('/add-station')}}" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-plus-lg"></i></span>
                        <span>Trạm mới</span>
                      </a>
                    </li>
  
                    <li>
                      <a href="{{URL::to('/station-list')}}" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-list-check"></i></span>
                        <span>Danh sách các trạm</span>
                      </a>
                    </li>
                  </ul>
                
                
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>

            <li>
                <a
                  class="nav-link px-3 sidebar-link"
                  data-bs-toggle="collapse"
                  href="#layouts2"
                >
                  <span class="me-2"><i class="bi bi-person"></i></span>
                  <span>QL Nhân Viên</span>
                  
                </a>
              
                  <ul class="navbar-nav ps-3">
                    <li>
                      <a href="{{URL::to('/add-user')}}" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-plus-lg"></i></span>
                        <span>Nhân Viên mới</span>
                      </a>
                    </li>
  
                    <li>
                      <a href="#" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-list-check"></i></span>
                        <span>Danh Sách nhân viên</span>
                      </a>
                    </li>
                  </ul>
                
                
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts3"
              >
                <span class="me-2"><i class="bi bi-truck"></i></span>
                <span>QL Xe Tải</span>
               
              </a>
              
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="{{URL::to('/add-truck')}}" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-plus-lg"></i></span>
                      <span>Xe Tải mới</span>
                    </a>
                  </li>

                  <li>
                    <a href="{{URL::to('/trucks-details')}}" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-list-check"></i></span>
                      <span>Chi tiết các xe</span>
                    </a>
                  </li>
                </ul>
              
              
          </li>

            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                QL BLOG
              </div>
            </li>
            <ul class="navbar-nav ps-3">
              <li>
                <a href="{{URL::to('/add-blog')}}" class="nav-link px-3">
                  <span class="me-2"><i class="bi bi-plus"></i></span>
                  <span>Thêm BLog mới</span>
                </a>
              </li>
              <li>
                <a href="{{URL::to('/list-blog')}}" class="nav-link px-3">
                  <span class="me-2"><i class="bi bi-list-check"></i></span>
                  <span>Danh sách Blog</span>
                </a>
              </li>
            </ul>
              
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">
        
        @yield('admin_content')

        
      </div>
    </main>
    <script src={{asset("public/backend/js/bootstrap.bundle.min.js")}}></script>
    <script src={{asset("https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js")}}></script>
    <script src={{asset("public/backend/js/jquery-3.5.1.js")}}></script>
    <script src={{asset("public/backend/js/jquery.dataTables.min.js")}}></script>
    <script src={{asset("public/backend/js/dataTables.bootstrap5.min.js")}}></script>
    <script src={{asset("public/backend/js/script.js")}}></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script> --}}
    <script>
      $(document).ready( function () {
          $('#myTable').DataTable();
      } );
  </script>
  <script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
        ClassicEditor
        .create( document.querySelector( '#editor1' ) )
        .catch( error => {
            console.error( error );
        } );
        ClassicEditor
        .create( document.querySelector( '#editor2' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
  </body>
</html>
