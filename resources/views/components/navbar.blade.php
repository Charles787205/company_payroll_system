<!-- start navbar -->
<div class="md:fixed md:w-full md:top-0 md:z-20 flex flex-row flex-wrap items-center bg-white p-4 border-b border-gray-200 shadow-sm">

  <!-- logo -->
  <div class="flex-none w-56 flex flex-row items-center">
    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-purple-100 text-purple-600 mr-3">
      <span class="material-symbols-outlined">payments</span>
    </div>
    <strong class="capitalize text-gray-700 font-medium">Company Payroll System</strong>

    <button id="sliderBtn" class="flex-none text-right text-gray-900 hidden md:block ml-2">
      <span class="material-symbols-outlined">menu</span>
    </button>
  </div>
  <!-- end logo -->

  <!-- navbar content toggle -->
  <button id="navbarToggle" class="hidden md:block md:fixed right-0 mr-6">
    <span class="material-symbols-outlined">expand_more</span>
  </button>
  <!-- end navbar content toggle -->

  <!-- navbar content -->
  <div id="navbar"
    class="animated md:hidden md:fixed md:top-0 md:w-full md:left-0 md:mt-16 md:border-t md:border-b md:border-gray-200 md:p-10 md:bg-white flex-1 pl-3 flex flex-row flex-wrap justify-between items-center md:flex-col md:items-center">
    
    <!-- left -->
    <div class="text-gray-600 md:w-full md:flex md:flex-row md:justify-evenly md:pb-10 md:mb-10 md:border-b md:border-gray-200">
      <a class="mr-4 transition duration-500 ease-in-out hover:text-purple-600" href="#" title="Dashboard">
        <span class="material-symbols-outlined">dashboard</span>
      </a>
      <a class="mr-4 transition duration-500 ease-in-out hover:text-purple-600" href="#" title="Employees">
        <span class="material-symbols-outlined">group</span>
      </a>
      <a class="mr-4 transition duration-500 ease-in-out hover:text-purple-600" href="#" title="Payroll">
        <span class="material-symbols-outlined">payments</span>
      </a>
      <a class="mr-4 transition duration-500 ease-in-out hover:text-purple-600" href="#" title="Calendar">
        <span class="material-symbols-outlined">calendar_month</span>
      </a>
    </div>
    <!-- end left -->

    <!-- right -->
    <div class="flex flex-row-reverse items-center">

      <!-- user -->
      <div class="dropdown relative md:static">

        <button class="menu-btn focus:outline-none focus:shadow-outline flex flex-wrap items-center">
          <div class="w-8 h-8 overflow-hidden rounded-full bg-purple-100 flex items-center justify-center text-purple-500">
            <span class="material-symbols-outlined">person</span>
          </div>

          <div class="ml-2 capitalize flex">
            <h1 class="text-sm text-gray-800 font-medium m-0 p-0 leading-none">
              {{ Auth::check() ? Auth::user()->first_name : 'Guest' }}
            </h1>
            <span class="material-symbols-outlined ml-1 text-xs leading-none">expand_more</span>
          </div>
        </button>

        <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

        <div class="text-gray-500 menu hidden md:mt-10 md:w-full rounded bg-white shadow-md absolute z-20 right-0 w-40 mt-5 py-2 animated faster">

          <!-- item -->
          <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-100 hover:text-purple-600 transition-all duration-300 ease-in-out flex items-center"
            href="#">
            <span class="material-symbols-outlined text-sm mr-2">edit</span>
            Edit Profile
          </a>
          <!-- end item -->

          <!-- item -->
          <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-100 hover:text-purple-600 transition-all duration-300 ease-in-out flex items-center"
            href="#">
            <span class="material-symbols-outlined text-sm mr-2">settings</span>
            Settings
          </a>
          <!-- end item -->

          <hr>

          <!-- item -->
          <a class="px-4 py-2 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-100 hover:text-purple-600 transition-all duration-300 ease-in-out flex items-center"
            href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="material-symbols-outlined text-sm mr-2">logout</span>
            Log Out
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
          </form>
          <!-- end item -->

        </div>
      </div>
      <!-- end user -->

      <!-- notifications -->
      <div class="dropdown relative mr-5 md:static">

        <button class="text-gray-500 menu-btn p-0 m-0 hover:text-purple-600 focus:text-purple-600 focus:outline-none transition-all ease-in-out duration-300 relative">
          <span class="material-symbols-outlined">notifications</span>
          <span class="absolute -top-1 -right-1 text-xs bg-red-500 text-white font-bold rounded-full h-4 w-4 flex items-center justify-center">3</span>
        </button>

        <button class="hidden fixed top-0 left-0 z-10 w-full h-full menu-overflow"></button>

        <div class="menu hidden rounded bg-white md:right-0 md:w-full shadow-lg absolute z-20 right-0 w-84 mt-5 py-2 animated faster">
          <!-- top -->
          <div class="px-4 py-2 flex flex-row justify-between items-center capitalize font-medium text-sm">
            <h1>Notifications</h1>
            <div class="bg-purple-100 text-purple-600 text-xs rounded px-2 py-1">
              <span>3 New</span>
            </div>
          </div>
          <hr>
          <!-- end top -->

          <!-- body -->

          <!-- item -->
          <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out"
            href="#">

            <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-200 text-purple-500">
              <span class="material-symbols-outlined text-sm">payments</span>
            </div>

            <div class="flex-1 flex flex-row justify-between">
              <div class="flex-1">
                <h1 class="text-sm font-semibold">New payroll processed</h1>
                <p class="text-xs text-gray-500">Your May payroll has been processed</p>
              </div>
              <div class="text-right text-xs text-gray-500">
                <p>4 min ago</p>
              </div>
            </div>

          </a>
          <hr>
          <!-- end item -->

          <!-- item -->
          <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out"
            href="#">

            <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-200 text-green-500">
              <span class="material-symbols-outlined text-sm">task_alt</span>
            </div>

            <div class="flex-1 flex flex-row justify-between">
              <div class="flex-1">
                <h1 class="text-sm font-semibold">Attendance approved</h1>
                <p class="text-xs text-gray-500">Your attendance has been approved</p>
              </div>
              <div class="text-right text-xs text-gray-500">
                <p>2 hours ago</p>
              </div>
            </div>

          </a>
          <hr>
          <!-- end item -->

          <!-- item -->
          <a class="flex flex-row items-center justify-start px-4 py-4 block capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-50 transition-all duration-300 ease-in-out"
            href="#">

            <div class="px-3 py-2 rounded mr-3 bg-gray-100 border border-gray-200 text-blue-500">
              <span class="material-symbols-outlined text-sm">event_upcoming</span>
            </div>

            <div class="flex-1 flex flex-row justify-between">
              <div class="flex-1">
                <h1 class="text-sm font-semibold">Upcoming payroll</h1>
                <p class="text-xs text-gray-500">New payroll period starts tomorrow</p>
              </div>
              <div class="text-right text-xs text-gray-500">
                <p>1 day ago</p>
              </div>
            </div>

          </a>
          <!-- end item -->

          <!-- end body -->

          <!-- bottom -->
          <hr>
          <div class="px-4 py-2 mt-2">
            <a href="#"
              class="border border-gray-300 block text-center text-xs uppercase rounded py-2 hover:text-purple-600 transition-all ease-in-out duration-500">
              View All Notifications
            </a>
          </div>
          <!-- end bottom -->
        </div>
      </div>
      <!-- end notifications -->

      <!-- help button -->
      <div class="mr-4">
        <button class="text-gray-500 p-0 m-0 hover:text-purple-600 focus:text-purple-600 focus:outline-none transition-all ease-in-out duration-300">
          <span class="material-symbols-outlined">help</span>
        </button>
      </div>
      <!-- end help button -->

    </div>
    <!-- end right -->
  </div>
  <!-- end navbar content -->

</div>
<!-- end navbar -->