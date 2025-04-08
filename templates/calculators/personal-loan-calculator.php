<div class="fcp-container">
  <h2>Personal Loan EMI Calculator</h2>
  <p><em>Calculate your monthly EMI for a personal loan</em></p>

  <form id="personalLoanForm">
    <label>Loan Amount: <input type="number" id="pLoanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="pInterestRate" required></label><br><br>
    <label>Loan Tenure (Years): <input type="number" id="pLoanTenure" required></label><br><br>
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
  <canvas id="personalLoanChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadPersonalLoanPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} / month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;

  drawPersonalLoanChart(P, totalInterest);
}

function drawPersonalLoanChart(principal, interest) {
  const ctx = document.getElementById('personalLoanChart').getContext('2d');
  if (window.plChart) window.plChart.destroy();
  window.plChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Principal', 'Interest'],
      datasets: [{
        data: [principal, interest],
        backgroundColor: ['#2196F3', '#FF5722'],
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

function downloadPersonalLoanPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Personal Loan EMI Result", 10, 10);
  const content = document.getElementById('personalLoanResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("personal-loan-emi.pdf");
}
</script>
