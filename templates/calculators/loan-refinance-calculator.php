<div class="fcp-container">
  <h2>Loan Refinance Calculator</h2>
  <p><em>Compare your current EMI with estimated refinance option</em></p>

  <form id="refinanceForm">
    <label>Current EMI: <input type="number" id="currentEMI" required></label><br><br>
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
  <canvas id="refinanceChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadRefinancePDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
  const newEMI = emi * (1 - (newRate * 0.05)); // rough estimate
  const newTotal = newEMI * months;
  const savings = currentTotal - newTotal;

  document.getElementById('refinanceResult').innerHTML = `
    <h3>Estimated New EMI: ${currency} ${newEMI.toFixed(2)}</h3>
    <ul>
      <li><strong>Current Total Repayment:</strong> ${currency} ${currentTotal.toFixed(2)}</li>
      <li><strong>New Total Repayment:</strong> ${currency} ${newTotal.toFixed(2)}</li>
      <li><strong>Estimated Savings:</strong> ${currency} ${savings.toFixed(2)}</li>
    </ul>
  `;

  drawRefinanceChart(currentTotal, newTotal);
}

function drawRefinanceChart(current, newTotal) {
  const ctx = document.getElementById('refinanceChart').getContext('2d');
  if (window.refChart) window.refChart.destroy();
  window.refChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Current Total', 'New Total'],
      datasets: [{
        data: [current, newTotal],
        backgroundColor: ['#FF9800', '#4CAF50'],
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

function downloadRefinancePDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Loan Refinance Result", 10, 10);
  const content = document.getElementById('refinanceResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("loan-refinance.pdf");
}
</script>
