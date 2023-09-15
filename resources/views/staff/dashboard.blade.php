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
    <title>THYN Express Staff</title>
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
                <li><a class="dropdown-item" href="{{URL::to('/staff/profile')}}">
                    <span>
                        <i class="bi bi-person"></i>
                    </span>
                    <span> Profile</span>
                    </a>
                </li>
                <li><a class="dropdown-item" href="{{URL::to('/staff/setting')}}"><span><i class="bi bi-gear"></i></span> Setting</a></li>
                <li>
                  <a class="dropdown-item" href="{{URL::to('/admin-logout')}}"> <span><i class="bi bi-key-fill"></i></span> Log-out</a>
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
                Staff
              </div>
            </li>
            <li>
              <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts"
              >
                <span class="me-2"><i class="bi bi-layout-split"></i></span>
                <span>Manage Tracking</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-chevron-down"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="{{URL::to('/staff/confirm-arrived')}}" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-plus-lg"></i></span>
                      <span>Confirm Arrived</span>
                    </a>
                  </li>

                  {{-- <li>
                    <a href="{{URL::to('/posision-list')}}" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="bi bi-list-check"></i></span>
                      <span>Posision List</span>
                    </a>
                  </li> --}}
                </ul>
              </div>
              
            </li>

            {{-- <li>
                <a
                  class="nav-link px-3 sidebar-link"
                  data-bs-toggle="collapse"
                  href="#layouts1"
                >
                  <span class="me-2"><i class="bi bi-house"></i></span>
                  <span>Manage Station</span>
                  <span class="ms-auto">
                    <span class="right-icon">
                      <i class="bi bi-chevron-down"></i>
                    </span>
                  </span>
                </a>
                <div class="collapse" id="layouts1">
                  <ul class="navbar-nav ps-3">
                    <li>
                      <a href="{{URL::to('/add-station')}}" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-plus-lg"></i></span>
                        <span>Add New Station</span>
                      </a>
                    </li>
  
                    <li>
                      <a href="{{URL::to('/station-list')}}" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-list-check"></i></span>
                        <span>Station List</span>
                      </a>
                    </li>
                  </ul>
                </div>
                
            </li> --}}


            {{-- <li>
                <a
                  class="nav-link px-3 sidebar-link"
                  data-bs-toggle="collapse"
                  href="#layouts2"
                >
                  <span class="me-2"><i class="bi bi-person"></i></span>
                  <span>Manage User</span>
                  <span class="ms-auto">
                    <span class="right-icon">
                      <i class="bi bi-chevron-down"></i>
                    </span>
                  </span>
                </a>
                <div class="collapse" id="layouts2">
                  <ul class="navbar-nav ps-3">
                    <li>
                      <a href="{{URL::to('/add-user')}}" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-plus-lg"></i></span>
                        <span>Add New User</span>
                      </a>
                    </li>
  
                    <li>
                      <a href="#" class="nav-link px-3">
                        <span class="me-2"
                          ><i class="bi bi-list-check"></i></span>
                        <span>User List</span>
                      </a>
                    </li>
                  </ul>
                </div>
                
            </li> --}}

            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                Sorting Center
              </div>
            </li>
            {{-- <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                <span>Charts</span>
              </a>
            </li>
            <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-table"></i></span>
                <span>Tables</span>
              </a>
            </li> --}}

            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                Truck Drivers
              </div>
            </li>
            {{-- <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                <span>Charts</span>
              </a>
            </li>
            <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-table"></i></span>
                <span>Tables</span>
              </a>
            </li> --}}

            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
            <li>
              <div class="text-muted small fw-bold text-uppercase px-3 mb-3">
                Delivery Man
              </div>
            </li>
            {{-- <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-graph-up"></i></span>
                <span>Charts</span>
              </a>
            </li>
            <li>
              <a href="#" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-table"></i></span>
                <span>Tables</span>
              </a>
            </li> --}}
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">
      <div class="container-fluid">
        
        @yield('staff-content')

        
      </div>
    </main>
    <script src={{asset("public/backend/js/bootstrap.bundle.min.js")}}></script>
    <script src={{asset("public/backendttps://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js")}}></script>
    <script src={{asset("public/backend/js/jquery-3.5.1.js")}}></script>
    <script src={{asset("public/backend/js/jquery.dataTables.min.js")}}></script>
    <script src={{asset("public/backend/js/dataTables.bootstrap5.min.js")}}></script>
    <script src={{asset("public/backend/js/script.js")}}></script>
  </body>
</html>
