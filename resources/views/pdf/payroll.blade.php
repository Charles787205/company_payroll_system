<?php
$payroll->employee->user->name = htmlspecialchars($payroll->employee->user->name, ENT_QUOTES, 'UTF-8');
function convertNumberToWords($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'forty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convertNumberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convertNumberToWords(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[(int) $hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convertNumberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convertNumberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convertNumberToWords($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return $string;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll Details</title>
  <style>
    body {
      font-family: 'Poppins', 'DejaVu Sans', sans-serif;
      font-size: 13px;
      line-height: 1.5;
      color: #333;
      background-color: #f8f6f9;
      margin: 0;
      padding: 20px;
    }
    
    .container {
      max-width: 800px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
      position: relative;
    }
    
    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #e6e1f0;
      padding-bottom: 20px;
      position: relative;
    }
    
    .header h1 {
      font-size: 28px;
      color: #5a4a8a;
      margin: 5px 0;
      letter-spacing: 1px;
    }
    
    .header p {
      color: #777;
      margin: 5px 0;
    }
    
    .logo {
      position: absolute;
      top: 0;
      left: 0;
      width: 120px;
      text-align: left;
    }
    
    .logo-text {
      font-size: 18px;
      font-weight: bold;
      color: #5a4a8a;
    }
    
    .logo-subtext {
      font-size: 11px;
      color: #777;
    }
    
    .document-info {
      position: absolute;
      top: 0;
      right: 0;
      text-align: right;
    }
    
    .document-info p {
      margin: 3px 0;
      font-size: 11px;
    }
    
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 5px;
    }
    
    .status-paid {
      background-color: #d1f7dd;
      color: #0d6832;
    }
    
    .status-approved {
      background-color: #d0e2ff;
      color: #0043ce;
    }
    
    .status-pending {
      background-color: #fff8e1;
      color: #b28704;
    }
    
    .employee-details {
      display: flex;
      justify-content: space-between;
      margin-bottom: 30px;
      background-color: #f9f7fa;
      padding: 15px;
      border-radius: 8px;
    }
    
    .detail-group {
      margin-bottom: 20px;
      flex: 1;
    }
    
    .detail-group h3 {
      font-size: 15px;
      color: #5a4a8a;
      margin-bottom: 10px;
      border-bottom: 1px solid #e6e1f0;
      padding-bottom: 5px;
    }
    
    .detail-group p {
      margin: 5px 0;
      font-size: 12px;
    }
    
    .detail-group strong {
      display: inline-block;
      width: 110px;
      color: #555;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
      font-size: 12px;
    }

    th, td {
      padding: 12px;
      text-align: left;
    }
    
    th {
      background-color: #e6e1f0;
      font-weight: 600;
      color: #5a4a8a;
    }
    
    .summary-table tr:nth-child(even) {
      background-color: #f9f7fa;
    }
    
    .deduction-table {
      margin-top: 20px;
    }
    
    .deduction-table th, .deduction-table td {
      padding: 8px;
    }
    
    .total-row {
      font-weight: bold;
      background-color: #e6e1f0 !important;
    }
    
    .section-title {
      color: #5a4a8a;
      font-size: 16px;
      margin-top: 25px;
      margin-bottom: 10px;
      padding-bottom: 5px;
      border-bottom: 1px solid #e6e1f0;
      display: flex;
      align-items: center;
    }
    
    .section-title::before {
      content: '';
      display: none; /* Hide the original dot */
    }
    
    .section-title .material-icon {
      color: #5a4a8a;
      margin-right: 8px;
    }
    
    .net-pay {
      text-align: right;
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
      color: #ffffff;
      padding: 15px;
      background-color: #5a4a8a;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .attendance-summary {
      margin-top: 20px;
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      background-color: #f9f7fa;
      padding: 15px;
      border-radius: 8px;
    }
    
    .attendance-item {
      text-align: center;
      flex: 1;
      padding: 10px;
    }
    
    .attendance-value {
      font-size: 18px;
      font-weight: bold;
      color: #5a4a8a;
      margin-bottom: 5px;
    }
    
    .attendance-label {
      font-size: 11px;
      color: #777;
    }
    
    .footer {
      margin-top: 50px;
      font-size: 11px;
      color: #777;
      text-align: center;
      border-top: 1px solid #e6e1f0;
      padding-top: 15px;
    }
    
    .signature-area {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
    }
    
    .signature-box {
      width: 45%;
      text-align: center;
    }
    
    .signature-line {
      border-top: 1px solid #ccc;
      margin-top: 40px;
      margin-bottom: 5px;
    }
    
    .verification-code {
      margin-top: 30px;
      text-align: center;
      font-family: monospace;
      font-size: 14px;
      letter-spacing: 1px;
      color: #777;
      background-color: #f9f7fa;
      padding: 8px;
      border-radius: 4px;
    }
    
    .watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-45deg);
      font-size: 100px;
      color: rgba(90, 74, 138, 0.05);
      z-index: -1;
      white-space: nowrap;
    }
    
    .pay-details {
      display: flex;
      margin-bottom: 20px;
    }
    
    .pay-item {
      flex: 1;
      text-align: center;
      padding: 15px;
      background-color: #f9f7fa;
      margin: 0 5px;
      border-radius: 8px;
    }
    
    .pay-item-label {
      font-size: 12px;
      color: #777;
      margin-bottom: 5px;
    }
    
    .pay-item-value {
      font-size: 16px;
      font-weight: bold;
      color: #5a4a8a;
    }
    
    .pay-item-value.earnings {
      color: #0d6832;
    }
    
    .pay-item-value.deductions {
      color: #d32f2f;
    }
    
    .qr-code {
      width: 80px;
      height: 80px;
      margin: 10px auto;
      background-color: #e6e1f0;
      padding: 5px;
      border-radius: 4px;
    }
    
    .amount-words {
      font-style: italic;
      color: #555;
      font-size: 11px;
      margin-top: 8px;
    }
    
    .tax-summary {
      margin-top: 20px;
      margin-bottom: 20px;
      background-color: #f9f7fa;
      padding: 15px;
      border-radius: 8px;
    }
    
    .tax-title {
      font-size: 14px;
      font-weight: bold;
      color: #5a4a8a;
      margin-bottom: 10px;
    }
    
    .tax-row {
      display: flex;
      justify-content: space-between;
      padding: 5px 0;
      border-bottom: 1px dashed #e6e1f0;
    }
    
    .tax-row:last-child {
      border-bottom: none;
    }
    
    .tax-label {
      color: #555;
    }
    
    .tax-value {
      font-weight: 600;
    }
    
    .year-to-date {
      margin-top: 25px;
      border: 1px solid #e6e1f0;
      border-radius: 8px;
      overflow: hidden;
    }
    
    .ytd-header {
      background-color: #5a4a8a;
      color: white;
      padding: 10px 15px;
      font-weight: bold;
    }
    
    .ytd-body {
      display: flex;
      flex-wrap: wrap;
      padding: 15px;
    }
    
    .ytd-item {
      width: 50%;
      padding: 5px 0;
    }
    
    .ytd-label {
      font-size: 11px;
      color: #777;
    }
    
    .ytd-value {
      font-weight: bold;
      color: #333;
    }
    
    .payment-method {
      display: flex;
      align-items: center;
      margin-top: 20px;
      padding: 15px;
      background-color: #f9f7fa;
      border-radius: 8px;
    }
    
    .payment-icon {
      background-color: #5a4a8a;
      color: white;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      margin-right: 15px;
    }
    
    /* Material Icons styling */
    .material-icon {
      font-family: 'Material Symbols Outlined';
      font-size: 20px;
      display: inline-block;
      vertical-align: middle;
      margin-right: 5px;
    }
    
    .section-title::before {
      content: '';
      display: none; /* Hide the original dot */
    }
    
    .section-title .material-icon {
      color: #5a4a8a;
      margin-right: 8px;
    }
    
    .icon-earnings::before {
      content: "payments";
    }
    
    .icon-deductions::before {
      content: "receipt_long";
    }
    
    .icon-tax::before {
      content: "calculate";
    }
    
    .icon-payment::before {
      content: "account_balance";
    }
    
    .icon-attendance::before {
      content: "event_available";
    }
    
    .icon-signature::before {
      content: "draw";
    }
    
    .icon-verification::before {
      content: "verified";
    }
    
    .icon-calendar::before {
      content: "calendar_month";
    }
    
    .icon-status::before {
      content: "info";
    }
    
    .status-badge {
      display: inline-flex;
      align-items: center;
      padding: 4px 8px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: bold;
      text-transform: uppercase;
      margin-top: 5px;
    }
    
    .payment-details {
      flex-grow: 1;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="watermark">OFFICIAL PAYSLIP</div>
    <div class="header">
      <div class="logo">
        <div class="logo-text">Company Payroll</div>
        <div class="logo-subtext">Your Trusted Payroll Partner</div>
      </div>
      
      <div class="document-info">
        <p><strong>Document:</strong> PAYSLIP</p>
        <p><strong>Reference ID:</strong> {{ sprintf('PAY-%06d', $payroll->id) }}</p>
        <p><strong>Issue Date:</strong> {{ date('F d, Y', strtotime($payroll->updated_at)) }}</p>
        
        @php
          $statusClass = 'status-pending';
          $statusIcon = 'pending';
          if($payroll->status === 'paid') {
            $statusClass = 'status-paid';
            $statusIcon = 'check_circle';
          } elseif($payroll->status === 'approved') {
            $statusClass = 'status-approved';
            $statusIcon = 'verified';
          }
        @endphp
        
        <div class="qr-code">
          <!-- QR Code placeholder - would be generated in production -->
        </div>
        
        <span class="status-badge {{ $statusClass }}">
          <span class="material-icon">{{ $statusIcon }}</span>
          {{ strtoupper($payroll->status) }}
        </span>
      </div>
      
      <h1>EMPLOYEE PAYSLIP</h1>
      <p>Payroll Period: <strong>{{ date('F d', strtotime($payroll->from_date)) }} - {{ date('F d, Y', strtotime($payroll->to_date)) }}</strong></p>
    </div>
    
    <div class="employee-details">
      <div class="detail-group">
        <h3>Employee Information</h3>
        <p><strong>Name:</strong> {{ strtoupper($payroll->employee->user->getFullName()) }}</p>
        <p><strong>Position:</strong> {{ $payroll->employee->position->title }}</p>
        <p><strong>ID Number:</strong> {{ sprintf('EMP-%04d', $payroll->employee->id) }}</p>
        <p><strong>Department:</strong> {{ $payroll->employee->position->department ?? 'General' }}</p>
        <p><strong>Date Hired:</strong> {{ date('M d, Y', strtotime($payroll->employee->date_hired)) }}</p>
      </div>
      
      <div class="detail-group">
        <h3>Payment Information</h3>
        <p><strong>Payment Date:</strong> {{ date('F d, Y', strtotime($payroll->updated_at)) }}</p>
        <p><strong>Payment Method:</strong> Direct Deposit</p>
        <p><strong>Pay Frequency:</strong> Semi-Monthly</p>
        <p><strong>Currency:</strong> PHP (₱)</p>
        <p><strong>Bank Account:</strong> XXXX-XXXX-{{ sprintf('%04d', $payroll->employee->id) }}</p>
      </div>
    </div>
    
    <div class="pay-details">
      <div class="pay-item">
        <div class="pay-item-label">GROSS EARNINGS</div>
        <div class="pay-item-value earnings">₱{{ number_format($payroll->amount, 2) }}</div>
      </div>
      
      @php $totalDeductions = $payroll->employee->loansAndDeductions->sum('amount'); @endphp
      
      <div class="pay-item">
        <div class="pay-item-label">TOTAL DEDUCTIONS</div>
        <div class="pay-item-value deductions">₱{{ number_format($totalDeductions, 2) }}</div>
      </div>
      
      <div class="pay-item">
        <div class="pay-item-label">NET PAY</div>
        <div class="pay-item-value">₱{{ number_format($payroll->amount - $totalDeductions, 2) }}</div>
      </div>
    </div>

    <div class="amount-words">
      {{ ucwords(convertNumberToWords($payroll->amount - $totalDeductions)) }} Pesos Only
    </div>

    <div class="attendance-summary">
      <div class="attendance-item">
        <div class="attendance-value">{{ $payroll->getWorkedAttendances()->count() }}</div>
        <div class="attendance-label">DAYS WORKED</div>
      </div>
      
      <div class="attendance-item">
        <div class="attendance-value">{{ 22 - $payroll->getWorkedAttendances()->count() }}</div>
        <div class="attendance-label">DAYS ABSENT</div>
      </div>
      
      <div class="attendance-item">
        <div class="attendance-value">0</div>
        <div class="attendance-label">OVERTIME HOURS</div>
      </div>
      
      <div class="attendance-item">
        <div class="attendance-value">0</div>
        <div class="attendance-label">LEAVE DAYS TAKEN</div>
      </div>
    </div>
    
    <div class="section-title">
      <span class="material-icon icon-earnings"></span>
      Earnings Summary
    </div>
    <table class="summary-table">
      <tr>
        <th width="40%">Description</th>
        <th width="20%">Rate</th>
        <th width="20%">Days/Hours</th>
        <th width="20%">Amount</th>
      </tr>
      <tr>
        <td>Base Salary</td>
        <td>₱{{ number_format($payroll->employee->salary / 22, 2) }}/day</td>
        <td>{{ $payroll->getWorkedAttendances()->count() }} days</td>
        <td>₱{{ number_format($payroll->amount, 2) }}</td>
      </tr>
      <tr>
        <td>Overtime Pay</td>
        <td>₱0.00/hour</td>
        <td>0 hours</td>
        <td>₱0.00</td>
      </tr>
      <tr>
        <td>Holiday Pay</td>
        <td>-</td>
        <td>-</td>
        <td>₱0.00</td>
      </tr>
      <tr class="total-row">
        <td colspan="3"><strong>Total Earnings</strong></td>
        <td><strong>₱{{ number_format($payroll->amount, 2) }}</strong></td>
      </tr>
    </table>
    
    <div class="section-title">
      <span class="material-icon icon-deductions"></span>
      Deduction Breakdown
    </div>
    <table class="deduction-table">
      <tr>
        <th width="40%">Description</th>
        <th width="40%">Type</th>
        <th width="20%">Amount</th>
      </tr>
      
      @php $totalDeductions = 0; @endphp
      
      @if($payroll->employee->loansAndDeductions->count() > 0)
        @foreach($payroll->employee->loansAndDeductions as $deduction)
          <tr>
            <td>{{ $deduction->name }}</td>
            <td>{{ ucfirst($deduction->type ?? 'Deduction') }}</td>
            <td>₱{{ number_format($deduction->amount, 2) }}</td>
          </tr>
          @php $totalDeductions += $deduction->amount; @endphp
        @endforeach
      @else
        <tr>
          <td colspan="3" style="text-align: center">No deductions for this period</td>
        </tr>
      @endif
      
      <tr class="total-row">
        <td colspan="2"><strong>Total Deductions</strong></td>
        <td><strong>₱{{ number_format($totalDeductions, 2) }}</strong></td>
      </tr>
    </table>
    
    <div class="tax-summary">
      <div class="tax-title"><span class="material-icon icon-tax"></span> Tax Summary</div>
      <div class="tax-row">
        <div class="tax-label">Withholding Tax:</div>
        <div class="tax-value">₱0.00</div>
      </div>
      <div class="tax-row">
        <div class="tax-label">SSS Contribution:</div>
        <div class="tax-value">₱0.00</div>
      </div>
      <div class="tax-row">
        <div class="tax-label">PhilHealth:</div>
        <div class="tax-value">₱0.00</div>
      </div>
      <div class="tax-row">
        <div class="tax-label">Pag-IBIG:</div>
        <div class="tax-value">₱0.00</div>
      </div>
    </div>
    
    <div class="payment-method">
      <div class="payment-icon">
        <span class="material-icon icon-payment"></span>
      </div>
      <div class="payment-details">
        <div class="payment-title">Payment Method: Direct Deposit</div>
        <div class="payment-info">Amount will be credited to your bank account within 24 hours of processing.</div>
      </div>
    </div>
    
    <div class="net-pay">
      NET PAY: ₱{{ number_format($payroll->amount - $totalDeductions, 2) }}
    </div>
    
    <div class="year-to-date">
      <div class="ytd-header">Year-to-Date Summary (2025)</div>
      <div class="ytd-body">
        <div class="ytd-item">
          <div class="ytd-label">YTD Gross:</div>
          <div class="ytd-value">₱{{ number_format($payroll->amount * 3, 2) }}</div>
        </div>
        <div class="ytd-item">
          <div class="ytd-label">YTD Deductions:</div>
          <div class="ytd-value">₱{{ number_format($totalDeductions * 3, 2) }}</div>
        </div>
        <div class="ytd-item">
          <div class="ytd-label">YTD Net Pay:</div>
          <div class="ytd-value">₱{{ number_format(($payroll->amount - $totalDeductions) * 3, 2) }}</div>
        </div>
        <div class="ytd-item">
          <div class="ytd-label">YTD Tax Paid:</div>
          <div class="ytd-value">₱0.00</div>
        </div>
      </div>
    </div>
    
    <div class="signature-area">
      <div class="signature-box">
        <div class="signature-line"></div>
        <p>{{ strtoupper($payroll->employee->user->getFullName()) }}</p>
        <p>Employee Signature</p>
      </div>
      
      <div class="signature-box">
        <div class="signature-line"></div>
        <p>HR Manager</p>
        <p>Authorized Signature</p>
      </div>
    </div>
    
    <div class="verification-code">
      Verification Code: {{ strtoupper(substr(md5($payroll->id . $payroll->employee->id), 0, 12)) }}
    </div>
    
    <div class="footer">
      <p>This is a computer-generated document and does not require physical signature.</p>
      <p>For any payroll inquiries, please contact the HR department at hr@company.com or ext. 123.</p>
      <p>&copy; {{ date('Y') }} Company Payroll System. All rights reserved.</p>
    </div>
  </div>
</body>

</html>