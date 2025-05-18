<x-app-layout>
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-2">My Loans and Deductions</h1>
    <p class="text-gray-500 text-sm">View all your current loan balances and payroll deductions</p>
  </div>

  <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
    <div class="p-6">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
          <span class="material-symbols-outlined text-purple-600 mr-2 text-xl">receipt_long</span>
          <h2 class="font-semibold text-gray-700">Deduction History</h2>
        </div>
        
        <div class="flex items-center space-x-2">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
            </div>
            <input type="text" id="search" placeholder="Search deductions..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-300">
          </div>
          
          <select id="filter" class="border border-gray-200 rounded-md text-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-300">
            <option value="all">All Types</option>
            <option value="loan">Loans</option>
            <option value="tax">Tax</option>
            <option value="insurance">Insurance</option>
            <option value="other">Others</option>
          </select>
        </div>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($loansAndDeductions as $deduction)
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-700">{{ $deduction->description ?? 'Payroll Deduction' }}</div>
                <div class="text-xs text-gray-500">#{{ $deduction->id }}</div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  @php
                    $typeIcon = 'payments';
                    $typeColor = 'text-purple-500';
                    
                    if (strtolower($deduction->type) == 'loan') {
                      $typeIcon = 'account_balance';
                      $typeColor = 'text-blue-500';
                    } elseif (strtolower($deduction->type) == 'tax') {
                      $typeIcon = 'receipt_long';
                      $typeColor = 'text-red-500';
                    } elseif (strtolower($deduction->type) == 'insurance') {
                      $typeIcon = 'health_and_safety';
                      $typeColor = 'text-green-500';
                    }
                  @endphp
                  
                  <span class="material-symbols-outlined {{ $typeColor }} mr-2">{{ $typeIcon }}</span>
                  <span class="text-sm text-gray-700">{{ $deduction->type }}</span>
                </div>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm text-red-600 font-medium">-₱{{ number_format($deduction->amount, 2) }}</span>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-sm text-gray-700">{{ $deduction->created_at->format('M d, Y') }}</span>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Active
                </span>
              </td>
              
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-2 view-details-btn" data-id="{{ $deduction->id }}">
                  <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                </button>
                <button class="text-gray-500 hover:text-gray-700 print-details-btn" data-id="{{ $deduction->id }}">
                  <span class="material-symbols-outlined" style="font-size: 18px;">download</span>
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="px-6 py-10 text-center">
                <div class="flex flex-col items-center justify-center text-gray-500">
                  <span class="material-symbols-outlined text-5xl mb-3">payments_off</span>
                  <p>No loans or deductions found.</p>
                  <p class="text-sm mt-1">Your deduction history will appear here once any deductions are applied.</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Deduction Details Modal -->
  <div id="deduction-details-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4 overflow-hidden">
      <div class="flex justify-between items-center p-4 border-b bg-gray-50">
        <h3 class="font-semibold text-gray-700 flex items-center">
          <span class="material-symbols-outlined mr-2">receipt_long</span>
          Deduction Details
        </h3>
        <button id="close-details-modal" class="text-gray-400 hover:text-gray-500">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div>
            <p class="text-sm text-gray-500 mb-1">Deduction ID</p>
            <p class="text-md font-medium" id="detail-id">#123</p>
          </div>
          <div>
            <p class="text-sm text-gray-500 mb-1">Date Applied</p>
            <p class="text-md font-medium" id="detail-date">May 15, 2025</p>
          </div>
          <div>
            <p class="text-sm text-gray-500 mb-1">Type</p>
            <p class="text-md font-medium" id="detail-type">Loan</p>
          </div>
          <div>
            <p class="text-sm text-gray-500 mb-1">Amount</p>
            <p class="text-md font-medium text-red-600" id="detail-amount">-₱5,000.00</p>
          </div>
        </div>
        
        <div class="mb-6">
          <p class="text-sm text-gray-500 mb-1">Description</p>
          <p class="text-md" id="detail-description">Monthly loan payment</p>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-md mb-6">
          <h4 class="font-medium text-gray-700 mb-2">Payment Schedule</h4>
          <div class="space-y-2" id="payment-schedule">
            <div class="flex justify-between text-sm">
              <span>May 15, 2025</span>
              <span class="text-green-600">Paid - ₱500.00</span>
            </div>
            <div class="flex justify-between text-sm">
              <span>June 15, 2025</span>
              <span class="text-gray-600">Upcoming - ₱500.00</span>
            </div>
            <div class="flex justify-between text-sm">
              <span>July 15, 2025</span>
              <span class="text-gray-600">Upcoming - ₱500.00</span>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 flex justify-end">
        <button id="close-details-btn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 flex items-center" onclick="document.getElementById('deduction-details-modal').classList.add('hidden')">
          <span class="material-symbols-outlined mr-1">close</span>
          Close
        </button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // View details buttons
      const viewDetailsButtons = document.querySelectorAll('.view-details-btn');
      const deductionDetailsModal = document.getElementById('deduction-details-modal');
      const closeDetailsModal = document.getElementById('close-details-modal');
      const closeDetailsBtn = document.getElementById('close-details-btn');
      
      viewDetailsButtons.forEach(button => {
        button.addEventListener('click', function() {
          const deductionId = this.getAttribute('data-id');
          
          // In a real implementation, you would fetch the deduction details
          // For demo purposes, we'll just show the modal with sample data
          document.getElementById('detail-id').textContent = '#' + deductionId;
          
          deductionDetailsModal.classList.remove('hidden');
        });
      });
      
      // Close modal events
      closeDetailsModal.addEventListener('click', function() {
        deductionDetailsModal.classList.add('hidden');
      });
      
      closeDetailsBtn.addEventListener('click', function() {
        deductionDetailsModal.classList.add('hidden');
      });
      
      // Close modal when clicking outside
      window.addEventListener('click', function(event) {
        if (event.target === deductionDetailsModal) {
          deductionDetailsModal.classList.add('hidden');
        }
      });
      
      // Search and filter functionality
      const searchInput = document.getElementById('search');
      const filterSelect = document.getElementById('filter');
      const tableRows = document.querySelectorAll('tbody tr');
      
      function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value.toLowerCase();
        
        tableRows.forEach(row => {
          // Skip the "no data" row
          if (row.cells.length === 1 && row.cells[0].colSpan > 1) {
            return;
          }
          
          const descriptionText = row.cells[0].textContent.toLowerCase();
          const typeText = row.cells[1].textContent.toLowerCase();
          
          const matchesSearch = descriptionText.includes(searchTerm);
          const matchesFilter = filterValue === 'all' || typeText.includes(filterValue);
          
          if (matchesSearch && matchesFilter) {
            row.classList.remove('hidden');
          } else {
            row.classList.add('hidden');
          }
        });
      }
      
      searchInput.addEventListener('input', filterTable);
      filterSelect.addEventListener('change', filterTable);
    });
  </script>
</x-app-layout>