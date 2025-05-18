<!-- start sidebar -->
<div id="sideBar"
  class="relative flex flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-64 md:-ml-64 md:fixed md:top-0 md:z-30 md:h-screen md:shadow-xl animated faster">

  <!-- sidebar content -->
  <div class="flex flex-col">

    <!-- sidebar toggle -->
    <div class="text-right hidden md:block mb-4">
      <button id="sideBarHideBtn">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <!-- end sidebar toggle -->

    <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">Management</p>

    <!-- Check if the user is an admin -->
    @if (Auth::user() && strtolower(Auth::user()->employee->position->title) === 'admin')
    <!-- Admin Links -->
    <!-- Dashboard -->
    <a href="/" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">dashboard</span>
      Dashboard
    </a>
    <!-- Employees -->
    <a href="/employees"
      class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">group</span>
      Employees
    </a>
    <!-- Positions -->
    <a href="/positions"
      class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">work</span>
      Positions
    </a>
    <!-- Payroll -->
    <a href="/payrolls"
      class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">payments</span>
      Payroll
    </a>
    <!-- Loans and Deductions -->
    <a href="/loans_and_deductions"
      class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">account_balance</span>
      Loans and Deductions
    </a>
    <!-- Attendance option removed for admin -->
    @else
    <!-- Non-Admin Links -->
    <!-- Attendance -->
    <a href="/" class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">calendar_month</span>
      Attendance
    </a>
    <!-- Payroll -->
    <a href="/employee-view/payrolls"
      class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">receipt_long</span>
      Payroll
    </a>
    <!-- Loans and Deductions -->
    <a href="/employee-view/loans_and_deductions"
      class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500 flex items-center">
      <span class="material-symbols-outlined text-lg mr-2">savings</span>
      Loans and Deductions
    </a>
    @endif

  </div>
  <!-- end sidebar content -->

</div>
<!-- end sidebar -->