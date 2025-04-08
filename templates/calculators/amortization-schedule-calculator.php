<div class="fcp-container">
  <h2>Amortization Schedule Calculator</h2>
  <p><em>Generate a schedule of your loan repayment with interest & principal split</em></p>

  <form id="amortForm">
    <label>Loan Amount: <input type="number" id="aLoanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="aInterestRate" required></label><br><br>
    <label>Loan Tenure (Years): <input type="number" id="aTenure" required></label><br><br>
    <label>Currency:
      <select id="aCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="generateSchedule()">Generate Schedule</button>
  </form>

  <div id="amortResult" style="margin-top: 20px;"></div>
  <div style="margin-top: 20px;">
    <button onclick="downloadAmortPDF()">Export to PDF</button>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function generateSchedule() {
  const P = parseFloat(document.getElementById('aLoanAmount').value);
  const R = parseFloat(document.getElementById('aInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('aTenure').value) * 12;
  const currency = document.getElementById('aCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('amortResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  let balance = P;
  let result = `<h3>Monthly EMI: ${currency} ${emi.toFixed(2)}</h3><table border='1' cellpadding='5'><tr><th>Month</th><th>Principal</th><th>Interest</th><th>Balance</th></tr>`;

  for (let i = 1; i <= N; i++) {
    const interest = balance * R;
    const principal = emi - interest;
    balance -= principal;
    result += `<tr><td>${i}</td><td>${currency} ${principal.toFixed(2)}</td><td>${currency} ${interest.toFixed(2)}</td><td>${currency} ${balance.toFixed(2)}</td></tr>`;
  }

  result += "</table>";
  document.getElementById('amortResult').innerHTML = result;
}

function downloadAmortPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Amortization Schedule", 10, 10);
  const content = document.getElementById('amortResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("amortization-schedule.pdf");
}
</script>
