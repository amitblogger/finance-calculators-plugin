<div class="fcp-container">
  <h2>Payday Loan Calculator</h2>
  <p><em>Estimate the cost and repayment of a short-term payday loan</em></p>

  <form id="paydayForm">
    <label>Loan Amount: <input type="number" id="payLoanAmount" required></label><br><br>
    <label>Loan Term (Days): <input type="number" id="payTerm" required></label><br><br>
    <label>Annual Interest Rate (%): <input type="number" id="payInterest" required></label><br><br>
    <label>Currency:
      <select id="payCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculatePayday()">Calculate</button>
  </form>

  <div id="paydayResult" style="margin-top: 20px;"></div>
  <canvas id="paydayChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadPaydayPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculatePayday() {
  const P = parseFloat(document.getElementById('payLoanAmount').value);
  const days = parseFloat(document.getElementById('payTerm').value);
  const annualRate = parseFloat(document.getElementById('payInterest').value);
  const currency = document.getElementById('payCurrency').value;

  if (isNaN(P) || isNaN(days) || isNaN(annualRate)) {
    document.getElementById('paydayResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const dailyRate = annualRate / 365 / 100;
  const interest = P * dailyRate * days;
  const total = P + interest;

  document.getElementById('paydayResult').innerHTML = `
    <h3>Total Repayment: ${currency} ${total.toFixed(2)}</h3>
    <ul>
      <li><strong>Loan Amount:</strong> ${currency} ${P.toFixed(2)}</li>
      <li><strong>Interest:</strong> ${currency} ${interest.toFixed(2)}</li>
      <li><strong>Duration:</strong> ${days} Days</li>
    </ul>
  `;

  drawPaydayChart(P, interest);
}

function drawPaydayChart(principal, interest) {
  const ctx = document.getElementById('paydayChart').getContext('2d');
  if (window.pdChart) window.pdChart.destroy();
  window.pdChart = new Chart(ctx, {
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

function downloadPaydayPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Payday Loan Result", 10, 10);
  const content = document.getElementById('paydayResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("payday-loan.pdf");
}
</script>
