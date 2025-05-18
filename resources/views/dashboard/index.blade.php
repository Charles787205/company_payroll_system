<x-app-layout>
  <div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-700 mb-2">Dashboard</h1>
    <p class="text-gray-500 text-sm">Welcome back, {{ Auth::user()->first_name }}! Here's an overview of your payroll system.</p>
  </div>

  <!-- General Report -->
  <x-general-report :total-employees="$totalEmployees" :approved-payrolls="$approvedPayrolls"
    :pending-payrolls="$pendingPayrolls" />
  <!-- End General Report -->

  <!-- Charts Section -->
  <div class="grid grid-cols-2 gap-6 mt-8 xl:grid-cols-1">
    <!-- Payroll Processing Chart -->
    <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden">
      <div class="card-body p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="font-semibold text-gray-700 flex items-center">
            <span class="material-symbols-outlined text-purple-600 mr-2">analytics</span>
            Payroll Processing Statistics
          </h3>
          <div class="flex space-x-2">
            <button class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">This Week</button>
            <button class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-700 hover:bg-purple-200 transition-colors">This Month</button>
            <button class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">This Year</button>
          </div>
        </div>
        <div id="payroll-chart" style="height: 250px;"></div>
      </div>
    </div>
    
    <!-- Employee Distribution Chart -->
    <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden">
      <div class="card-body p-6">
        <div class="flex items-center justify-between mb-6">
          <h3 class="font-semibold text-gray-700 flex items-center">
            <span class="material-symbols-outlined text-blue-600 mr-2">pie_chart</span>
            Employee Position Distribution
          </h3>
        </div>
        <div id="employee-chart" style="height: 250px;"></div>
      </div>
    </div>
  </div>

  <!-- Upcoming Payments Section -->
  <div class="card rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 bg-white overflow-hidden mt-8">
    <div class="card-body p-6">
      <div class="flex items-center justify-between mb-6">
        <h3 class="font-semibold text-gray-700 flex items-center">
          <span class="material-symbols-outlined text-green-600 mr-2">event_upcoming</span>
          Upcoming Payrolls
        </h3>
        <button class="px-3 py-1 text-sm rounded bg-green-100 text-green-700 hover:bg-green-200 transition-colors flex items-center">
          <span class="material-symbols-outlined text-sm mr-1">add</span>
          New Payroll
        </button>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payroll ID</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employees</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ rand(1000, 9999) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">May 16-31, 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ rand(5, 20) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₱{{ number_format(rand(50000, 200000), 2) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                  Pending
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                <a href="#" class="text-green-600 hover:text-green-900">Process</a>
              </td>
            </tr>
            <tr class="hover:bg-gray-50">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">#{{ rand(1000, 9999) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">June 1-15, 2025</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ rand(5, 20) }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">₱{{ number_format(rand(50000, 200000), 2) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                  Draft
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                <a href="#" class="text-green-600 hover:text-green-900">Process</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- ApexCharts Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Payroll Processing Chart
      var payrollOptions = {
        series: [{
          name: 'Processed Payrolls',
          data: [31, 40, 28, 51, 42, 109, 100]
        }, {
          name: 'Pending Payrolls',
          data: [11, 32, 45, 32, 34, 52, 41]
        }],
        chart: {
          height: 250,
          type: 'area',
          toolbar: {
            show: false
          }
        },
        colors: ['#8b5cf6', '#fbbf24'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        fill: {
          type: 'gradient',
          gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.3,
            opacityTo: 0.1,
            stops: [0, 90, 100]
          }
        },
        xaxis: {
          categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
        },
      };

      var payrollChart = new ApexCharts(document.querySelector("#payroll-chart"), payrollOptions);
      payrollChart.render();

      // Employee Distribution Chart
      var employeeOptions = {
        series: [44, 55, 13, 43, 22],
        chart: {
          height: 250,
          type: 'pie',
        },
        labels: ['Admin', 'IT Staff', 'HR', 'Accounting', 'Others'],
        colors: ['#8b5cf6', '#60a5fa', '#34d399', '#f59e0b', '#ef4444'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
      };

      var employeeChart = new ApexCharts(document.querySelector("#employee-chart"), employeeOptions);
      employeeChart.render();
    });
  </script>
</x-app-layout>