<div class="fcp-container">
  <h2>Auto Loan EMI Calculator</h2>
  <p><em>Calculate EMI for your new or used car loan</em></p>

  <form id="autoLoanForm">
    <label>Loan Amount: <input type="number" id="aLoanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="aInterestRate" required></label><br><br>
    <label>Loan Tenure (in Years): <input type="number" id="aLoanTenure" required></label><br><br>
    <label>Currency:
      <select id="aCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateAutoLoan()">Calculate EMI</button>
  </form>

  <div id="autoLoanResult" style="margin-top: 20px;"></div>
</div>

<script>
function calculateAutoLoan() {
  const P = parseFloat(document.getElementById('aLoanAmount').value);
  const R = parseFloat(document.getElementById('aInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('aLoanTenure').value) * 12;
  const currency = document.getElementById('aCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('autoLoanResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('autoLoanResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} per month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;
}
</script>
