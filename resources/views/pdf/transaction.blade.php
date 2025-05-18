<?php
$payroll->employee->user->name = htmlspecialchars($payroll->employee->user->name, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Transaction Receipt</title>
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
      overflow: hidden;
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
    
    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #e6e1f0;
      padding-bottom: 20px;
      position: relative;
    }
    
    .header h1 {
      font-size: 24px;
      color: #5a4a8a;
      margin: 5px 0;
      letter-spacing: 1px;
    }
    
    .header p {
      color: #777;
      margin: 5px 0;
      font-size: 14px;
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
    
    .transaction-info {
      margin-bottom: 30px;
      padding: 20px;
      background-color: #f9f7fa;
      border-radius: 8px;
      border-left: 4px solid #5a4a8a;
    }
    
    .transaction-info h2 {
      font-size: 16px;
      color: #5a4a8a;
      margin-top: 0;
      margin-bottom: 15px;
    }
    
    .transaction-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      font-size: 13px;
    }
    
    .transaction-label {
      font-weight: bold;
      color: #555;
      width: 40%;
    }
    
    .transaction-value {
      width: 60%;
      text-align: right;
    }
    
    .amount-section {
      margin: 30px 0;
      text-align: center;
    }
    
    .currency {
      font-size: 20px;
      font-weight: bold;
      color: #5a4a8a;
    }
    
    .amount {
      font-size: 36px;
      font-weight: bold;
      color: #5a4a8a;
      margin: 10px 0;
    }
    
    .amount-words {
      font-size: 14px;
      color: #777;
      font-style: italic;
    }
    
    .payment-details {
      margin: 30px 0;
      padding: 0 20px;
    }
    
    .payment-details h2 {
      font-size: 16px;
      color: #5a4a8a;
      margin-bottom: 15px;
      padding-bottom: 5px;
      border-bottom: 1px solid #e6e1f0;
    }
    
    .payment-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
    }
    
    .payment-label {
      font-weight: bold;
      color: #555;
      width: 40%;
    }
    
    .payment-value {
      width: 60%;
      padding-left: 20px;
    }
    
    .stamp {
      position: absolute;
      top: 50%;
      right: 30px;
      transform: translateY(-50%) rotate(15deg);
      border: 2px solid #5a4a8a;
      border-radius: 50%;
      padding: 20px;
      color: #5a4a8a;
      font-size: 16px;
      font-weight: bold;
      text-transform: uppercase;
      opacity: 0.7;
      width: 80px;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 5;
    }
    
    .verification-section {
      margin-top: 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .qr-code {
      width: 100px;
      height: 100px;
      background-color: #e6e1f0;
      padding: 5px;
      border-radius: 4px;
    }
    
    .verification-info {
      flex: 1;
      padding-left: 20px;
    }
    
    .verification-info h3 {
      font-size: 14px;
      color: #5a4a8a;
      margin-bottom: 5px;
    }
    
    .verification-info p {
      font-size: 12px;
      color: #777;
      margin: 5px 0;
    }
    
    .verification-code {
      font-family: monospace;
      font-size: 14px;
      letter-spacing: 1px;
      color: #5a4a8a;
      background-color: #f9f7fa;
      padding: 6px;
      border-radius: 4px;
      margin-top: 5px;
      display: inline-block;
    }
    
    .footer {
      margin-top: 50px;
      font-size: 11px;
      color: #777;
      text-align: center;
      border-top: 1px solid #e6e1f0;
      padding-top: 15px;
    }
    
    .footer p {
      margin: 5px 0;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="watermark">OFFICIAL RECEIPT</div>
    
    <div class="header">
      <div class="logo">
        <div class="logo-text">Company Payroll</div>
        <div class="logo-subtext">Your Trusted Payroll Partner</div>
      </div>
      
      <h1>PAYMENT TRANSACTION RECEIPT</h1>
      <p>This document certifies that the following payment has been processed successfully</p>
    </div>
    
    <div class="transaction-info">
      <h2>Transaction Information</h2>
      <div class="transaction-row">
        <div class="transaction-label">Transaction ID:</div>
        <div class="transaction-value">TXN-{{ sprintf('%08d', $payroll->id) }}</div>
      </div>
      <div class="transaction-row">
        <div class="transaction-label">Transaction Date:</div>
        <div class="transaction-value">{{ date('F d, Y H:i:s', strtotime($payroll->updated_at)) }}</div>
      </div>
      <div class="transaction-row">
        <div class="transaction-label">Payment Status:</div>
        <div class="transaction-value" style="color: #0d6832; font-weight: bold;">COMPLETED</div>
      </div>
      <div class="transaction-row">
        <div class="transaction-label">Payment Reference:</div>
        <div class="transaction-value">PAY-{{ strtoupper(substr(md5($payroll->id . $payroll->from_date), 0, 8)) }}</div>
      </div>
    </div>
    
    <div class="amount-section">
      <div class="currency">PHP</div>
      @php $netAmount = $payroll->amount - $payroll->employee->loansAndDeductions->sum('amount'); @endphp
      <div class="amount">₱{{ number_format($netAmount, 2) }}</div>
      <div class="amount-words">{{ ucwords(convertNumberToWords($netAmount)) }} Pesos Only</div>
    </div>
    
    <div class="payment-details">
      <h2>Payment Details</h2>
      <div class="payment-row">
        <div class="payment-label">Recipient:</div>
        <div class="payment-value">{{ strtoupper($payroll->employee->user->getFullName()) }}</div>
      </div>
      <div class="payment-row">
        <div class="payment-label">Employee ID:</div>
        <div class="payment-value">{{ sprintf('EMP-%04d', $payroll->employee->id) }}</div>
      </div>
      <div class="payment-row">
        <div class="payment-label">Payment Period:</div>
        <div class="payment-value">{{ date('F d', strtotime($payroll->from_date)) }} - {{ date('F d, Y', strtotime($payroll->to_date)) }}</div>
      </div>
      <div class="payment-row">
        <div class="payment-label">Payment Method:</div>
        <div class="payment-value">Direct Deposit</div>
      </div>
      <div class="payment-row">
        <div class="payment-label">Account Number:</div>
        <div class="payment-value">XXXX-XXXX-{{ sprintf('%04d', $payroll->employee->id) }}</div>
      </div>
      <div class="payment-row">
        <div class="payment-label">Gross Amount:</div>
        <div class="payment-value">₱{{ number_format($payroll->amount, 2) }}</div>
      </div>
      <div class="payment-row">
        <div class="payment-label">Deductions:</div>
        <div class="payment-value">₱{{ number_format($payroll->employee->loansAndDeductions->sum('amount'), 2) }}</div>
      </div>
    </div>
    
    <div class="stamp">Paid</div>
    
    <div class="verification-section">
      <div class="qr-code">
        <!-- QR Code placeholder -->
      </div>
      <div class="verification-info">
        <h3>Verify this Transaction</h3>
        <p>To verify the authenticity of this receipt, visit our portal at payroll.company.com and enter the verification code below:</p>
        <div class="verification-code">{{ strtoupper(substr(md5($payroll->id . $payroll->employee->id . $payroll->amount), 0, 16)) }}</div>
      </div>
    </div>
    
    <div class="footer">
      <p>This is an official receipt of payment. Please retain for your records.</p>
      <p>For any inquiries regarding this payment, please contact the HR department at hr@company.com or ext. 123.</p>
      <p>&copy; {{ date('Y') }} Company Payroll System. All rights reserved.</p>
    </div>
  </div>
  
  <?php
  // Helper function to convert numbers to words
  function convertNumberToWords($number) {
    $ones = array(
      0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five", 
      6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 
      11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 
      15 => "fifteen", 16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 
      19 => "nineteen"
    );
    
    $tens = array(
      2 => "twenty", 3 => "thirty", 4 => "forty", 5 => "fifty", 
      6 => "sixty", 7 => "seventy", 8 => "eighty", 9 => "ninety"
    );
    
    $hundreds = array(
      "hundred", "thousand", "million", "billion", "trillion", "quadrillion"
    );
    
    if ($number == 0) {
      return $ones[0];
    }
    
    $number = number_format($number, 2, '.', '');
    
    $numberArray = explode('.', $number);
    $wholeNumber = $numberArray[0];
    $decimal = $numberArray[1];
    
    // Convert whole number
    $result = "";
    if ($wholeNumber < 20) {
      $result .= $ones[$wholeNumber];
    } elseif ($wholeNumber < 100) {
      $result .= $tens[floor($wholeNumber / 10)];
      $result .= ($wholeNumber % 10) ? " " . $ones[$wholeNumber % 10] : "";
    } elseif ($wholeNumber < 1000) {
      $result .= $ones[floor($wholeNumber / 100)] . " " . $hundreds[0];
      $result .= ($wholeNumber % 100) ? " and " . convertNumberToWords($wholeNumber % 100) : "";
    } elseif ($wholeNumber < 1000000) {
      $result .= convertNumberToWords(floor($wholeNumber / 1000)) . " " . $hundreds[1];
      $result .= ($wholeNumber % 1000) ? " " . convertNumberToWords($wholeNumber % 1000) : "";
    }
    
    // Add decimal part if not zero
    if ($decimal != "00") {
      $result .= " and " . $decimal . "/100";
    }
    
    return $result;
  }
  ?>
</body>

</html>