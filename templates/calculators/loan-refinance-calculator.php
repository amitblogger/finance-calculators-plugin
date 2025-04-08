<div class="fcp-container">
  <h2>Loan Refinance Calculator</h2>
  <p><em>Compare current and new loan to estimate refinancing benefits</em></p>

  <form id="refinanceForm">
    <label>Current Loan EMI: <input type="number" id="currentEMI" required></label><br><br>
    <label>Remaining Tenure (Months): <input type="number" id="remainingMonths" required></label><br><br>
    <label>New Loan Interest Rate (% per annum): <input type="number" id="newRate" required></label><br><br>
    <label>Currency:
      <select id="refinanceCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateRefinance()">Compare</button>
  </form>

  <div id="refinanceResult" style="margin-top: 20px;"></div>
</div>

<script>
function calculateRefinance() {
  const emi = parseFloat(document.getElementById('currentEMI').value);
  const months = parseFloat(document.getElementById('remainingMonths').value);
  const newRate = parseFloat(document.getElementById('newRate').value) / 12 / 100;
  const currency = document.getElementById('refinanceCurrency').value;

  if (isNaN(emi) || isNaN(months) || isNaN(newRate)) {
    document.getElementById('refinanceResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const currentTotal = emi * months;
  const newEMI = emi * (1 - (newRate * 0.05)); // estimated reduction
  const newTotal = newEMI * months;
  const savings = currentTotal - newTotal;

  document.getElementById('refinanceResult').innerHTML = `
    <h3>Estimated Monthly EMI after Refinance: ${currency} ${newEMI.toFixed(2)}</h3>
    <ul>
      <li><strong>Old Total Repayment:</strong> ${currency} ${currentTotal.toFixed(2)}</li>
      <li><strong>New Total Repayment:</strong> ${currency} ${newTotal.toFixed(2)}</li>
      <li><strong>Estimated Savings:</strong> ${currency} ${savings.toFixed(2)}</li>
    </ul>
  `;
}
</script>
