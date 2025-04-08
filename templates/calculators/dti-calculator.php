<div class="fcp-container">
  <h2>Debt-to-Income Ratio Calculator</h2>
  <p><em>Check your monthly debt burden compared to income</em></p>

  <form id="dtiForm">
    <label>Total Monthly Debt Payments: <input type="number" id="debtPayments" required></label><br><br>
    <label>Gross Monthly Income: <input type="number" id="monthlyIncome" required></label><br><br>
    <label>Currency:
      <select id="dtiCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateDTI()">Calculate DTI</button>
  </form>

  <div id="dtiResult" style="margin-top: 20px;"></div>
  <canvas id="dtiChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadDTIPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculateDTI() {
  const debt = parseFloat(document.getElementById('debtPayments').value);
  const income = parseFloat(document.getElementById('monthlyIncome').value);
  const currency = document.getElementById('dtiCurrency').value;

  if (isNaN(debt) || isNaN(income) || income === 0) {
    document.getElementById('dtiResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const dti = (debt / income) * 100;

  let status = '';
  if (dti < 20) status = 'Excellent';
  else if (dti <= 35) status = 'Good';
  else if (dti <= 50) status = 'Needs Improvement';
  else status = 'High Risk';

  document.getElementById('dtiResult').innerHTML = `
    <h3>Your DTI: ${dti.toFixed(2)}%</h3>
    <p>Status: <strong>${status}</strong></p>
  `;

  drawDTIChart(dti, 100 - dti);
}

function drawDTIChart(dtiPercent, rest) {
  const ctx = document.getElementById('dtiChart').getContext('2d');
  if (window.dtiChart) window.dtiChart.destroy();
  window.dtiChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Debt', 'Remaining Income'],
      datasets: [{
        data: [dtiPercent, rest],
        backgroundColor: ['#FF9800', '#03A9F4'],
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

function downloadDTIPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Debt-to-Income Ratio Result", 10, 10);
  const content = document.getElementById('dtiResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("dti-result.pdf");
}
</script>
