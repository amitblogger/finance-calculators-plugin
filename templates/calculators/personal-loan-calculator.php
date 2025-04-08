<div class="fcp-container">
  <h2>Personal Loan EMI Calculator</h2>
  <p><em>Calculate your monthly EMI for a personal loan</em></p>

  <form id="personalLoanForm">
    <label>Loan Amount: <input type="number" id="pLoanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="pInterestRate" required></label><br><br>
    <label>Loan Tenure (in Years): <input type="number" id="pLoanTenure" required></label><br><br>
    <label>Currency:
      <select id="pCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculatePersonalLoan()">Calculate EMI</button>
  </form>

  <div id="personalLoanResult" style="margin-top: 20px;"></div>
</div>

<script>
function calculatePersonalLoan() {
  const P = parseFloat(document.getElementById('pLoanAmount').value);
  const R = parseFloat(document.getElementById('pInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('pLoanTenure').value) * 12;
  const currency = document.getElementById('pCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('personalLoanResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('personalLoanResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} per month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;
}
</script>
