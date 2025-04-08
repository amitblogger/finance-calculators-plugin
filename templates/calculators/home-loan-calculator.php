<div class="fcp-container">
  <h2>Home Loan EMI Calculator</h2>
  <p><em>Estimate your monthly payments for a home loan</em></p>

  <form id="homeLoanForm">
    <label>Loan Amount: <input type="number" id="hLoanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="hInterestRate" required></label><br><br>
    <label>Loan Tenure (in Years): <input type="number" id="hLoanTenure" required></label><br><br>
    <label>Currency:
      <select id="hCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateHomeLoan()">Calculate EMI</button>
  </form>

  <div id="homeLoanResult" style="margin-top: 20px;"></div>
</div>

<script>
function calculateHomeLoan() {
  const P = parseFloat(document.getElementById('hLoanAmount').value);
  const R = parseFloat(document.getElementById('hInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('hLoanTenure').value) * 12;
  const currency = document.getElementById('hCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('homeLoanResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('homeLoanResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} per month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;
}
</script>
