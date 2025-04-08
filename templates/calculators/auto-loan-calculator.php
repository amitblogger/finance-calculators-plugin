<div class="fcp-container">
  <h2>Auto Loan EMI Calculator</h2>
  <p><em>Calculate EMI for your new or used car loan</em></p>

  <form id="autoLoanForm">
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
    <button type="button" onclick="calculateAutoLoan()">Calculate EMI</button>
  </form>

  <div id="autoLoanResult" style="margin-top: 20px;"></div>
  <canvas id="autoLoanChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadAutoLoanPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculateAutoLoan() {
  const P = parseFloat(document.getElementById('aLoanAmount').value);
  const R = parseFloat(document.getElementById('aInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('aTenure').value) * 12;
  const currency = document.getElementById('aCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('autoLoanResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('autoLoanResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} / month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;

  drawAutoLoanChart(P, totalInterest);
}

function drawAutoLoanChart(principal, interest) {
  const ctx = document.getElementById('autoLoanChart').getContext('2d');
  if (window.alChart) window.alChart.destroy();
  window.alChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Principal', 'Interest'],
      datasets: [{
        data: [principal, interest],
        backgroundColor: ['#FFC107', '#E91E63'],
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
}

function downloadAutoLoanPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Auto Loan EMI Result", 10, 10);
  const content = document.getElementById('autoLoanResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("auto-loan-emi.pdf");
}
</script>
