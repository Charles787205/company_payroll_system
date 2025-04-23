<div class="grid grid-cols-4 gap-6 xl:grid-cols-1">

  <!-- Total Employees Card -->
  <div class="report-card">
    <div class="card">
      <div class="card-body flex flex-col">
        <!-- top -->
        <div class="flex flex-row justify-between items-center">
          <div class="h6 text-indigo-700 fad fa-users"></div>
          <span class="rounded-full text-white badge bg-teal-400 text-xs">
            +10%
            <i class="fal fa-chevron-up ml-1"></i>
          </span>
        </div>
        <!-- end top -->

        <!-- bottom -->
        <div class="mt-8">
          <h1 class="h5 ">{{ $totalEmployees }}</h1>
          <p>Total Employees</p>
        </div>
        <!-- end bottom -->
      </div>
    </div>
    <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
  </div>
  <!-- end card -->

  <!-- Approved Payrolls Card -->
  <div class="report-card">
    <div class="card">
      <div class="card-body flex flex-col">
        <!-- top -->
        <div class="flex flex-row justify-between items-center">
          <div class="h6 text-green-700 fad fa-check-circle"></div>
          <span class="rounded-full text-white badge bg-teal-400 text-xs">
            +5%
            <i class="fal fa-chevron-up ml-1"></i>
          </span>
        </div>
        <!-- end top -->

        <!-- bottom -->
        <div class="mt-8">
          <h1 class="h5 ">{{ $approvedPayrolls }}</h1>
          <p>Approved Payrolls</p>
        </div>
        <!-- end bottom -->
      </div>
    </div>
    <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
  </div>
  <!-- end card -->

  <!-- Pending Payrolls Card -->
  <div class="report-card">
    <div class="card">
      <div class="card-body flex flex-col">
        <!-- top -->
        <div class="flex flex-row justify-between items-center">
          <div class="h6 text-yellow-600 fad fa-clock"></div>
          <span class="rounded-full text-white badge bg-red-400 text-xs">
            -2%
            <i class="fal fa-chevron-down ml-1"></i>
          </span>
        </div>
        <!-- end top -->

        <!-- bottom -->
        <div class="mt-8">
          <h1 class="h5 ">{{ $pendingPayrolls }}</h1>
          <p>Pending Payrolls</p>
        </div>
        <!-- end bottom -->
      </div>
    </div>
    <div class="footer bg-white p-1 mx-4 border border-t-0 rounded rounded-t-none"></div>
  </div>
  <!-- end card -->

</div>