<div class="fcp-container">
  <h2>EMI Calculator</h2>
  <p><em>Calculate your Equated Monthly Installment quickly</em></p>
  <form id="emiForm">
    <label>Loan Amount: <input type="number" id="loanAmount" required></label><br>
    <label>Interest Rate (% per annum): <input type="number" id="interestRate" required></label><br>
    <label>Loan Tenure (in Years): <input type="number" id="loanTenure" required></label><br>
    <label>Currency:
      <select id="currency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateEMI()">Calculate EMI</button>
  </form>
  <div id="emiResult"></div>
</div>
<script>
function calculateEMI() {
  const P = parseFloat(document.getElementById('loanAmount').value);
  const R = parseFloat(document.getElementById('interestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('loanTenure').value) * 12;
  const currency = document.getElementById('currency').value;
  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;
  document.getElementById('emiResult').innerHTML = `
    <h3>${currency} ${emi.toFixed(2)} per month</h3>
    <ul>
      <li>Total Interest: ${currency} ${totalInterest.toFixed(2)}</li>
      <li>Total Payable: ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>`;
}
</script>
