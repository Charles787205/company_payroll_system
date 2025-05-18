<x-app-layout>
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-2">Payroll Management</h1>
    <p class="text-gray-500 text-sm">Manage employee payrolls, approve attendance, and process payments</p>
  </div>
  
  <div class="flex flex-wrap items-center justify-between mb-6">
    <div class="flex items-center space-x-4">
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <span class="material-symbols-outlined text-gray-400 text-sm">search</span>
        </div>
        <input type="text" id="search-payroll" placeholder="Search employees..." 
               class="pl-10 pr-4 py-2 border border-gray-200 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-300">
      </div>
      
      <select id="status-filter" class="border border-gray-200 rounded-md text-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-purple-200 focus:border-purple-300">
        <option value="all">All Statuses</option>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="paid">Paid</option>
      </select>
    </div>
    
    <button id="create-payroll" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors flex items-center">
      <span class="material-symbols-outlined mr-2 text-sm">add</span>
      Create New Payroll
    </button>
  </div>
  
  <x-payroll.employee-table :employees="$employees" title="Payroll Records" :payrolls="$payrolls" />
</x-app-layout>