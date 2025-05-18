<div class="card rounded-lg shadow-sm overflow-hidden bg-white hover:shadow-md transition-shadow duration-300">
  <div class="card-body p-6">
    <h2 class="font-bold text-lg mb-6 text-gray-700">{{ $title }}</h2>

    @if ($payrolls->isEmpty())
    <div class="py-8 text-center text-gray-500 bg-gray-50 rounded-lg">
      <span class="material-symbols-outlined text-4xl mb-2">payments_off</span>
      <p>No payroll data available.</p>
    </div>
    @else
    <!-- start a table -->
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="text-left bg-gray-50">
          <tr>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600">Period</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-center">Days Worked</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-right">Base Salary</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-right">Deductions</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-right">Net Salary</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-center">Status</th>
            <th class="px-4 py-3 text-sm font-semibold tracking-wide text-gray-600 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach ($payrolls as $payroll)
          <tr class="hover:bg-gray-50">
            <!-- Period -->
            <td class="px-4 py-4 text-sm">
              <div class="font-medium text-gray-700">{{ $payroll->from_date}} - {{ $payroll->to_date}}</div>
              <div class="text-xs text-gray-500">Ref #{{ $payroll->id }}</div>
            </td>

            <!-- Days Worked -->
            <td class="px-4 py-4 text-sm text-center">
              <span class="inline-flex items-center">
                <span class="material-symbols-outlined text-blue-400 mr-1 text-sm">event_available</span>
                {{ $payroll->getWorkedAttendances()->count() }}
              </span>
            </td>

            <!-- Base Salary -->
            <td class="px-4 py-4 text-sm text-right">
              ₱{{ number_format($payroll->employee->salary, 2) }}
            </td>

            <!-- Deductions -->
            <td class="px-4 py-4 text-sm text-right">
              <span class="text-red-500">-₱{{ number_format($payroll->employee->loansAndDeductions->sum('amount'), 2) }}</span>
            </td>

            <!-- Net Salary -->
            <td class="px-4 py-4 font-medium text-right">
              <span class="text-green-600">₱{{ number_format($payroll->amount - $payroll->employee->loansAndDeductions->sum('amount'), 2) }}</span>
            </td>

            <!-- Status -->
            <td class="px-4 py-4 text-sm text-center">
              @if ($payroll->status === 'paid')
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <span class="material-symbols-outlined text-sm mr-1">check_circle</span>
                PAID
              </span>
              @else
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                <span class="material-symbols-outlined text-sm mr-1">pending</span>
                PENDING
              </span>
              @endif
            </td>

            <!-- Actions -->
            <td class="px-4 py-4 text-sm text-center">
              <div class="flex justify-center space-x-3">
                <button class="p-1.5 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 transition-colors view-attendance-btn" 
                        data-id="{{ $payroll->id }}" 
                        title="View Attendance">
                  <span class="material-symbols-outlined" style="font-size: 20px;">calendar_view_week</span>
                </button>

                @if ($payroll->status === 'paid')
                <a href="{{ route('payroll.download-pdf', $payroll->id) }}" 
                   class="p-1.5 rounded-full bg-green-50 text-green-500 hover:bg-green-100 transition-colors"
                   title="Download Payslip">
                  <span class="material-symbols-outlined" style="font-size: 20px;">download</span>
                </a>
                @endif
                
                <button class="p-1.5 rounded-full bg-purple-50 text-purple-500 hover:bg-purple-100 transition-colors view-deductions-btn"
                        data-id="{{ $payroll->id }}"
                        title="View Deductions">
                  <span class="material-symbols-outlined" style="font-size: 20px;">receipt_long</span>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
  </div>
</div>

<!-- Attendance Modal with Enhanced UI -->
<div id="attendance-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl mx-4 overflow-hidden">
    <div class="flex justify-between items-center p-4 border-b bg-gray-50">
      <h3 class="font-semibold text-gray-700 flex items-center">
        <span class="material-symbols-outlined mr-2">calendar_month</span>
        Attendance Details for Payroll #<span id="payroll-id"></span>
      </h3>
      <button id="close-modal" class="text-gray-400 hover:text-gray-500">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <div class="p-6 max-h-[70vh] overflow-auto">
      <div class="flex justify-between items-center mb-4 p-2 bg-blue-50 rounded-md">
        <div class="flex items-center">
          <span class="material-symbols-outlined text-blue-500 mr-2">info</span>
          <span class="text-sm text-blue-700">This is a record of your attendance for this pay period</span>
        </div>
        <div class="bg-white rounded-full px-3 py-1 text-xs font-medium text-blue-600 border border-blue-200 flex items-center">
          <span class="material-symbols-outlined mr-1" style="font-size: 14px;">badge</span>
          Attendance Record
        </div>
      </div>
      
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center">
                <span class="material-symbols-outlined mr-1 text-gray-400" style="font-size: 16px;">calendar_today</span>
                Date
              </div>
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center">
                <span class="material-symbols-outlined mr-1 text-gray-400" style="font-size: 16px;">login</span>
                Time In
              </div>
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center">
                <span class="material-symbols-outlined mr-1 text-gray-400" style="font-size: 16px;">logout</span>
                Time Out
              </div>
            </th>
            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center justify-center">
                <span class="material-symbols-outlined mr-1 text-gray-400" style="font-size: 16px;">verified</span>
                Status
              </div>
            </th>
          </tr>
        </thead>
        <tbody id="attendance-table" class="bg-white divide-y divide-gray-200">
          <!-- Table rows will be inserted here -->
        </tbody>
      </table>
    </div>
    <div class="bg-gray-50 px-4 py-3 flex justify-end">
      <button id="close-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 flex items-center transition-colors" onclick="document.getElementById('attendance-modal').classList.add('hidden')">
        <span class="material-symbols-outlined mr-1">close</span>
        Close
      </button>
    </div>
  </div>
</div>

<!-- Deductions Modal with Enhanced UI -->
<div id="deductions-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
    <div class="flex justify-between items-center p-4 border-b bg-gray-50">
      <h3 class="font-semibold text-gray-700 flex items-center">
        <span class="material-symbols-outlined mr-2">receipt_long</span>
        Deduction Breakdown
      </h3>
      <button id="close-deductions-modal" class="text-gray-400 hover:text-gray-500">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <div class="p-6">
      <div class="flex justify-between items-center mb-4 p-2 bg-red-50 rounded-md">
        <div class="flex items-center">
          <span class="material-symbols-outlined text-red-500 mr-2">info</span>
          <span class="text-sm text-red-700">These amounts have been deducted from your gross salary</span>
        </div>
        <div class="bg-white rounded-full px-3 py-1 text-xs font-medium text-red-600 border border-red-200 flex items-center">
          <span class="material-symbols-outlined mr-1" style="font-size: 14px;">payments</span>
          Deduction Record
        </div>
      </div>
      
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center">
                <span class="material-symbols-outlined mr-1 text-gray-400" style="font-size: 16px;">description</span>
                Description
              </div>
            </th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center justify-end">
                <span class="material-symbols-outlined mr-1 text-gray-400" style="font-size: 16px;">payments</span>
                Amount
              </div>
            </th>
          </tr>
        </thead>
        <tbody id="deductions-table" class="bg-white divide-y divide-gray-200">
          <!-- Deduction rows will be inserted here -->
        </tbody>
        <tfoot class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              <div class="flex items-center">
                <span class="material-symbols-outlined mr-1 text-gray-600" style="font-size: 16px;">calculate</span>
                Total
              </div>
            </th>
            <th id="total-deductions" class="px-6 py-3 text-right text-xs font-medium text-red-600 uppercase tracking-wider">₱0.00</th>
          </tr>
        </tfoot>
      </table>
    </div>
    <div class="bg-gray-50 px-4 py-3 flex justify-between">
      <div class="text-xs text-gray-500 flex items-center">
        <span class="material-symbols-outlined mr-1" style="font-size: 14px;">lightbulb</span>
        Contact HR for questions about your deductions
      </div>
      <button id="close-deductions-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 flex items-center transition-colors" onclick="document.getElementById('deductions-modal').classList.add('hidden')">
        <span class="material-symbols-outlined mr-1">close</span>
        Close
      </button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const attendanceModal = document.getElementById('attendance-modal');
    const closeModal = document.getElementById('close-modal');
    const closeBtn = document.getElementById('close-btn');
    const attendanceTable = document.getElementById('attendance-table');
    const payrollIdSpan = document.getElementById('payroll-id');
    
    const deductionsModal = document.getElementById('deductions-modal');
    const closeDeductionsModal = document.getElementById('close-deductions-modal');
    const closeDeductionsBtn = document.getElementById('close-deductions-btn');
    const deductionsTable = document.getElementById('deductions-table');
    const totalDeductions = document.getElementById('total-deductions');

    // Open attendance modal and fetch payroll data
    document.querySelectorAll('.view-attendance-btn').forEach(button => {
      button.addEventListener('click', function () {
        const payrollId = this.getAttribute('data-id');
        payrollIdSpan.textContent = payrollId;

        // Fetch payroll data
        fetch(`/employee-view/${payrollId}/attendances`)
          .then(response => response.json())
          .then(data => {
            // Clear existing table rows
            attendanceTable.innerHTML = '';

            // Populate table with attendance data
            data.attendances.forEach(attendance => {
              // Determine status based on time in and time out
              let statusIcon = '';
              let statusText = '';
              let statusClass = '';
              
              if (attendance.time_in && attendance.time_out) {
                statusIcon = 'check_circle';
                statusText = 'COMPLETE';
                statusClass = 'text-green-600 bg-green-50';
              } else if (attendance.time_in) {
                statusIcon = 'pending';
                statusText = 'PARTIAL';
                statusClass = 'text-yellow-600 bg-yellow-50';
              } else {
                statusIcon = 'error';
                statusText = 'MISSING';
                statusClass = 'text-red-600 bg-red-50';
              }
              
              const row = `
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <div class="flex items-center">
                      <span class="material-symbols-outlined mr-2 text-blue-500" style="font-size: 18px;">event</span>
                      ${attendance.date}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm ${attendance.time_in ? 'text-green-600' : 'text-gray-400'}">
                    <div class="flex items-center">
                      <span class="material-symbols-outlined mr-2 ${attendance.time_in ? 'text-green-500' : 'text-gray-400'}" style="font-size: 18px;">login</span>
                      ${attendance.time_in || 'Not recorded'}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm ${attendance.time_out ? 'text-green-600' : 'text-gray-400'}">
                    <div class="flex items-center">
                      <span class="material-symbols-outlined mr-2 ${attendance.time_out ? 'text-green-500' : 'text-gray-400'}" style="font-size: 18px;">logout</span>
                      ${attendance.time_out || 'Not recorded'}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusClass}">
                      <span class="material-symbols-outlined text-sm mr-1">${statusIcon}</span>
                      ${statusText}
                    </span>
                  </td>
                </tr>
              `;
              attendanceTable.insertAdjacentHTML('beforeend', row);
            });

            attendanceModal.classList.remove('hidden');
          })
          .catch(error => {
            console.error('Error fetching payroll data:', error);
          });
      });
    });

    // Open deductions modal and display deductions
    document.querySelectorAll('.view-deductions-btn').forEach(button => {
      button.addEventListener('click', function() {
        const payrollId = this.getAttribute('data-id');
        
        // Find the corresponding payroll row to get deductions
        const payrollRow = this.closest('tr');
        const deductionsAmount = payrollRow.querySelector('td:nth-child(4)').textContent.trim();
        
        // Fetch deductions data - This would ideally be an API call, but for demo we'll use dummy data
        // In a real implementation, you would fetch this data from the server
        fetch(`/employee-view/${payrollId}/deductions`)
          .then(response => response.json())
          .then(data => {
            // Clear existing table rows
            deductionsTable.innerHTML = '';
            let total = 0;
            
            // Populate table with deduction data
            data.deductions.forEach(deduction => {
              const amount = parseFloat(deduction.amount);
              total += amount;
              
              const typeIcon = getDeductionTypeIcon(deduction.type || 'general');
              
              const row = `
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <div class="flex items-center">
                      <span class="material-symbols-outlined mr-2 text-purple-500" style="font-size: 18px;">${typeIcon}</span>
                      ${deduction.name || deduction.description}
                      ${deduction.type ? `<span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600">${deduction.type}</span>` : ''}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-red-500">₱${amount.toFixed(2)}</td>
                </tr>
              `;
              deductionsTable.insertAdjacentHTML('beforeend', row);
            });
            
            // Update total
            totalDeductions.textContent = `₱${total.toFixed(2)}`;
            
            deductionsModal.classList.remove('hidden');
          })
          .catch(error => {
            console.error('Error fetching deductions data:', error);
            // Fallback to show a message if API fails
            deductionsTable.innerHTML = `
              <tr>
                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                  Unable to load deductions. Please try again later.
                </td>
              </tr>
            `;
            deductionsModal.classList.remove('hidden');
          });
      });
    });

    // Close attendance modal
    closeModal.addEventListener('click', function () {
      attendanceModal.classList.add('hidden');
    });
    
    closeBtn.addEventListener('click', function () {
      attendanceModal.classList.add('hidden');
    });
    
    // Close deductions modal
    closeDeductionsModal.addEventListener('click', function () {
      deductionsModal.classList.add('hidden');
    });
    
    closeDeductionsBtn.addEventListener('click', function () {
      deductionsModal.classList.add('hidden');
    });
    
    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
      if (event.target === attendanceModal) {
        attendanceModal.classList.add('hidden');
      }
      if (event.target === deductionsModal) {
        deductionsModal.classList.add('hidden');
      }
    });
  });
  
  function getDeductionTypeIcon(type) {
    switch(type.toLowerCase()) {
      case 'loan': return 'paid';
      case 'tax': return 'calculate';
      case 'insurance': return 'health_and_safety';
      case 'advance': return 'request_quote';
      case 'penalty': return 'warning';
      default: return 'receipt_long';
    }
  }
</script>