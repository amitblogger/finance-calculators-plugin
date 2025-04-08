<div class="fcp-container">
  <h2>EMI Calculator</h2>
  <p><em>Calculate your Equated Monthly Installment quickly</em></p>

  <form id="emiForm">
    <label>Loan Amount: <input type="number" id="loanAmount" required></label><br>
    <label>Interest Rate (%): <input type="number" id="interestRate" required></label><br>
    <label>Loan Tenure (Years): <input type="number" id="tenure" required></label><br>
    <label>Currency:
      <select id="currency">
        <option value=\"INR\">INR</option>
        <option value=\"USD\">USD</option>
        <option value=\"GBP\">GBP</option>
        <option value=\"EUR\">EUR</option>
        <option value=\"AUD\">AUD</option>
      </select>
    </label><br>
    <button type="button" onclick="calculateEMI()">Calculate EMI</button>
  </form>

  <div id="emiResult"></div>
</div>

<script>
function calculateEMI() {
  const P = parseFloat(document.getElementById('loanAmount').value);
  const R = parseFloat(document.getElementById('interestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('tenure').value) * 12;

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const currency = document.getElementById('currency').value;

  document.getElementById('emiResult').innerHTML = `<h3>Estimated EMI: ${currency} ${emi.toFixed(2)}</h3>`;
}
</script>
