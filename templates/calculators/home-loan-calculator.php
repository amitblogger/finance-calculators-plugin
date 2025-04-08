<div class="fcp-container">
  <h2>Home Loan EMI Calculator</h2>
  <p><em>Calculate your monthly EMI for home or mortgage loan</em></p>

  <form id="homeLoanForm">
    <label>Loan Amount: <input type="number" id="hLoanAmount" required></label><br><br>
    <label>Annual Interest Rate (%): <input type="number" id="hInterestRate" required></label><br><br>
    <label>Tenure (Years): <input type="number" id="hTenure" required></label><br><br>
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
  <canvas id="homeLoanChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadHomeLoanPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculateHomeLoan() {
  const P = parseFloat(document.getElementById('hLoanAmount').value);
  const R = parseFloat(document.getElementById('hInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('hTenure').value) * 12;
  const currency = document.getElementById('hCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('homeLoanResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('homeLoanResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} / month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;

  drawHomeLoanChart(P, totalInterest);
}

function drawHomeLoanChart(principal, interest) {
  const ctx = document.getElementById('homeLoanChart').getContext('2d');
  if (window.hlChart) window.hlChart.destroy();
  window.hlChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Principal', 'Interest'],
      datasets: [{
        data: [principal, interest],
        backgroundColor: ['#4CAF50', '#F44336'],
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

function downloadHomeLoanPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Home Loan EMI Result", 10, 10);
  const content = document.getElementById('homeLoanResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("home-loan-emi.pdf");
}
</script>
