<div class="fcp-container">
  <h2>EMI Calculator</h2>
  <p><em>Calculate your Equated Monthly Installment quickly</em></p>

  <form id="emiForm">
    <label>Loan Amount: <input type="number" id="loanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="interestRate" required></label><br><br>
    <label>Loan Tenure (Years): <input type="number" id="loanTenure" required></label><br><br>
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

  <div id="emiResult" style="margin-top: 20px;"></div>

  <canvas id="resultChart" width="400" height="250" style="margin-top:30px;"></canvas>

  <div style="margin-top: 20px;">
    <button onclick="downloadPDF()">Export Result to PDF</button>
  </div>
</div>

<!-- Chart.js & jsPDF (include only once in your main plugin or footer.php) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculateEMI() {
  const P = parseFloat(document.getElementById('loanAmount').value);
  const R = parseFloat(document.getElementById('interestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('loanTenure').value) * 12;
  const currency = document.getElementById('currency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('emiResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('emiResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} / month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;

  drawEMIChart(P, totalInterest);
}

// Draw Pie Chart using Chart.js
function drawEMIChart(principal, interest) {
  const ctx = document.getElementById('resultChart').getContext('2d');
  if (window.emiChart) window.emiChart.destroy(); // Destroy previous chart if exists
  window.emiChart = new Chart(ctx, {
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

// Export Result as PDF
function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Loan EMI Calculator Result", 10, 10);
  const content = document.getElementById('emiResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("emi-calculation.pdf");
}
</script>
