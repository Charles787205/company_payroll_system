<div class="card">

  <div class="card-body">
    <h2 class="font-bold text-lg mb-10">Recent Employees</h2>

    @if ($employees->isEmpty())
    <p class="text-center text-gray-500">No data available.</p>
    @else
    <!-- start a table -->
    <table class="table-fixed w-full">

      <!-- table head -->
      <thead class="text-left">
        <tr>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide">Employee</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Position</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Salary</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Hire Date</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Actions</th>
        </tr>
      </thead>
      <!-- end table head -->

      <!-- table body -->
      <tbody class="text-left text-gray-600">
        @foreach ($employees as $employee)
        <!-- item -->
        <tr>
          <!-- name -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider flex flex-row items-center w-full">
            <p class="ml-3 name-1">{{ $employee->user->getFullName() }}</p>
          </th>
          <!-- name -->

          <!-- position -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">{{ $employee->position->title }}
          </th>
          <!-- position -->

          <!-- salary -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($employee->salary, 2) }}</th>
          <!-- salary -->

          <!-- hire date -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">{{ $employee->hire_date }}</th>
          <!-- hire date -->

          <!-- actions -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            <form action="{{ route('employees.show', $employee->id) }}" method="GET">
              <button type="submit" class="btn-bs-primary text-sm px-4 py-2 ml-auto flex items-center justify-center">
                <span class="material-symbols-outlined mr-1 text-sm">visibility</span>
                View Details
              </button>
            </form>
          </th>
          <!-- actions -->
        </tr>
        <!-- item -->
        @endforeach
      </tbody>
      <!-- end table body -->

    </table>
    <!-- end a table -->
    @endif
  </div>

</div>