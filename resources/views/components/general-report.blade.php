<div class="grid grid-cols-4 gap-6 xl:grid-cols-1">

  <!-- Total Employees Card -->
  <div class="report-card">
    <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden">
      <div class="card-body flex flex-col p-6">
        <!-- top -->
        <div class="flex flex-row justify-between items-center">
          <span class="material-symbols-outlined text-3xl text-indigo-600">group</span>
          <span class="rounded-full text-white badge bg-teal-400 text-xs px-2 py-1 flex items-center">
            +10%
            <span class="material-symbols-outlined ml-1 text-[12px]">trending_up</span>
          </span>
        </div>
        <!-- end top -->

        <!-- bottom -->
        <div class="mt-6">
          <h1 class="text-3xl font-semibold text-gray-700">{{ $totalEmployees }}</h1>
          <p class="text-gray-500 mt-1">Total Employees</p>
        </div>
        <!-- end bottom -->

        <div class="mt-4 pt-4 border-t border-gray-100">
          <a href="/employees" class="text-indigo-600 hover:text-indigo-800 text-sm flex items-center transition-colors">
            <span>View all employees</span>
            <span class="material-symbols-outlined ml-1 text-[16px]">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- end card -->

  <!-- Approved Payrolls Card -->
  <div class="report-card">
    <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden">
      <div class="card-body flex flex-col p-6">
        <!-- top -->
        <div class="flex flex-row justify-between items-center">
          <span class="material-symbols-outlined text-3xl text-green-600">task_alt</span>
          <span class="rounded-full text-white badge bg-teal-400 text-xs px-2 py-1 flex items-center">
            +5%
            <span class="material-symbols-outlined ml-1 text-[12px]">trending_up</span>
          </span>
        </div>
        <!-- end top -->

        <!-- bottom -->
        <div class="mt-6">
          <h1 class="text-3xl font-semibold text-gray-700">{{ $approvedPayrolls }}</h1>
          <p class="text-gray-500 mt-1">Approved Payrolls</p>
        </div>
        <!-- end bottom -->

        <div class="mt-4 pt-4 border-t border-gray-100">
          <a href="/payrolls" class="text-green-600 hover:text-green-800 text-sm flex items-center transition-colors">
            <span>View processed payrolls</span>
            <span class="material-symbols-outlined ml-1 text-[16px]">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- end card -->

  <!-- Pending Payrolls Card -->
  <div class="report-card">
    <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden">
      <div class="card-body flex flex-col p-6">
        <!-- top -->
        <div class="flex flex-row justify-between items-center">
          <span class="material-symbols-outlined text-3xl text-amber-500">pending</span>
          <span class="rounded-full text-white badge bg-red-400 text-xs px-2 py-1 flex items-center">
            -2%
            <span class="material-symbols-outlined ml-1 text-[12px]">trending_down</span>
          </span>
        </div>
        <!-- end top -->

        <!-- bottom -->
        <div class="mt-6">
          <h1 class="text-3xl font-semibold text-gray-700">{{ $pendingPayrolls }}</h1>
          <p class="text-gray-500 mt-1">Pending Payrolls</p>
        </div>
        <!-- end bottom -->

        <div class="mt-4 pt-4 border-t border-gray-100">
          <a href="/payrolls" class="text-amber-600 hover:text-amber-800 text-sm flex items-center transition-colors">
            <span>Process pending payrolls</span>
            <span class="material-symbols-outlined ml-1 text-[16px]">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- end card -->
  
  <!-- Recent Activity Card -->
  <div class="report-card">
    <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden">
      <div class="card-body flex flex-col p-6">
        <!-- top -->
        <div class="flex flex-row justify-between items-center mb-4">
          <div class="flex items-center">
            <span class="material-symbols-outlined text-3xl text-purple-600 mr-2">history</span>
            <h3 class="font-semibold text-gray-700">Recent Activity</h3>
          </div>
        </div>
        <!-- end top -->

        <!-- activity feed -->
        <div class="mt-2 space-y-4">
          <div class="flex items-start">
            <span class="material-symbols-outlined text-green-500 mr-3">payments</span>
            <div>
              <p class="text-sm text-gray-700">Payroll #{{ rand(1000, 9999) }} was processed</p>
              <p class="text-xs text-gray-500">{{ now()->subHours(2)->format('F d, Y - h:i A') }}</p>
            </div>
          </div>
          <div class="flex items-start">
            <span class="material-symbols-outlined text-blue-500 mr-3">person_add</span>
            <div>
              <p class="text-sm text-gray-700">New employee was added</p>
              <p class="text-xs text-gray-500">{{ now()->subHours(5)->format('F d, Y - h:i A') }}</p>
            </div>
          </div>
          <div class="flex items-start">
            <span class="material-symbols-outlined text-amber-500 mr-3">request_quote</span>
            <div>
              <p class="text-sm text-gray-700">Loan request was submitted</p>
              <p class="text-xs text-gray-500">{{ now()->subHours(8)->format('F d, Y - h:i A') }}</p>
            </div>
          </div>
        </div>
        <!-- end activity feed -->

        <div class="mt-4 pt-4 border-t border-gray-100">
          <a href="#" class="text-purple-600 hover:text-purple-800 text-sm flex items-center transition-colors">
            <span>View all activity</span>
            <span class="material-symbols-outlined ml-1 text-[16px]">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- end card -->

</div>