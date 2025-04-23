<div class="card">
  <div class="card-body">
    <h2 class="font-bold text-lg mb-10">{{ $title }}</h2>

    @if ($payrolls->isEmpty())
    <p class="text-center text-gray-500">No payroll data available.</p>
    @else
    <!-- start a table -->
    <table class="table-fixed w-full">
      <thead class="text-left">
        <tr>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide">Employee</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Position</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Days Worked</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Base Salary</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Deductions</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Net Salary</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Status</th>
          <th class="w-1/4 pb-10 text-sm font-extrabold tracking-wide text-right">Action</th>
        </tr>
      </thead>
      <tbody class="text-left text-gray-600">
        @foreach ($payrolls as $payroll)
        <tr>
          <!-- Employee Name -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider flex flex-row items-center">
            <p class="ml-3 name-1">{{ $payroll->employee->user->getFullName() }}</p>
          </th>

          <!-- Position -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            {{ $payroll->employee->position->title }}
          </th>

          <!-- Days Worked -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            {{ $payroll->attendances->count() }}
          </th>

          <!-- Base Salary -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($payroll->employee->salary, 2) }}
          </th>

          <!-- Deductions -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($payroll->employee->loansAndDeductions->sum('amount'), 2) }}
          </th>

          <!-- Net Salary -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            ₱{{ number_format($payroll->employee->salary - $payroll->employee->loansAndDeductions->sum('amount'), 2) }}
          </th>

          <!-- Status -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            {{ $payroll->status === 'approved' ? 'Approved' : ($payroll->status === 'declined' ? 'Declined' : 'Pending') }}
          </th>

          <!-- Action -->
          <th class="w-1/4 mb-4 text-xs font-extrabold tracking-wider text-right">
            <button class="text-blue-500 hover:text-blue-700 view-attendance-btn" data-id="{{ $payroll->id }}"
              data-status="{{ $payroll->status }}">
              View
            </button>
          </th>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>

<x-payroll.attendance-modal :payrolls="$payrolls" />

<script>
  function updateButtonState(status) {
    const approveButton = document.getElementById('approve-attendance');
    const rejectButton = document.getElementById('reject-attendance');

    if (status.toLowerCase() != 'pending') {
      approveButton.disabled = true;
      rejectButton.disabled = true;
    } else {
      approveButton.disabled = false;
      rejectButton.disabled = false;
    }
  }
  document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('attendance-modal');
    const closeModal = document.getElementById('close-modal');
    const attendanceTable = document.getElementById('attendance-table');
    const payrollIdSpan = document.getElementById('payroll-id');

    // Open modal and fetch attendance data
    document.querySelectorAll('.view-attendance-btn').forEach(button => {
      button.addEventListener('click', function () {
        const payrollId = this.getAttribute('data-id');
        const status = this.getAttribute('data-status');
        // Set the payroll ID in the modal title
        payrollIdSpan.textContent = payrollId;
        console.log(payrollId)

        // Fetch attendance data
        fetch(`/payrolls/${payrollId}/attendances`)
          .then(response => response.json())
          .then(data => {
            // Clear existing table rows
            attendanceTable.innerHTML = '';

            // Populate table with attendance data
            data.attendances.forEach(attendance => {
              const row = `
                <tr>
                  <td class="border border-gray-300 px-4 py-2">${attendance.date}</td>
                  <td class="border border-gray-300 px-4 py-2">${attendance.time_in || 'N/A'}</td>
                  <td class="border border-gray-300 px-4 py-2">${attendance.time_out || 'N/A'}</td>
                </tr>
              `;
              attendanceTable.insertAdjacentHTML('beforeend', row);
            });
            updateButtonState(status);

            function setStatusAndSubmit(status) {
              document.getElementById('attendance-status').value = status;
              document.getElementById('update-status-form').submit();
            }

            modal.classList.remove('hidden');
            const updateForm = document.getElementById('update-status-form');
            updateForm.action = `/payrolls/${payrollId}/update-status`;
            updateForm.addEventListener("submit", function (event) {
              event.preventDefault(); // Prevent the default form submission
              const status = document.getElementById('attendance-status').value;
              if (status) {
                setStatusAndSubmit(status);
              }
            });
          })
          .catch(error => {
            console.error('Error fetching attendance data:', error);
          });
      });
    });

    // Close modal
    closeModal.addEventListener('click', function () {
      modal.classList.add('hidden');
    });
  });
</script>