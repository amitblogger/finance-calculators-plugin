<div class="fcp-container">
  <h2>SIP Calculator</h2>
  <p><em>Estimate the value of your monthly SIP investment</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="sipForm">
    <label>Monthly Investment: <input type="number" id="sipAmount" required></label><br><br>
    <label>Expected Annual Return (%): <input type="number" id="sipRate" required></label><br><br>
    <label>Investment Duration (Years): <input type="number" id="sipTime" required></label><br><br>
    <label>Currency:
      <select id="sipCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateSIP()">Calculate</button>
  </form>

  <div id="sipResult" style="margin-top: 20px;"></div>
  <canvas id="sipChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadSIPPdf()">Export Result to PDF</button></div>
</div>

<script>
function calculateSIP() {
  const A = parseFloat(document.getElementById('sipAmount').value);
  const R = parseFloat(document.getElementById('sipRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('sipTime').value) * 12;
  const currency = document.getElementById('sipCurrency').value;

  if (isNaN(A) || isNaN(R) || isNaN(N)) {
    document.getElementById('sipResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const futureValue = A * ((Math.pow(1 + R, N) - 1) / R) * (1 + R);
  const investedAmount = A * N;
  const returns = futureValue - investedAmount;

  document.getElementById('sipResult').innerHTML = `
    <h3>Maturity Value: ${currency} ${futureValue.toFixed(2)}</h3>
    <ul>
      <li><strong>Total Invested:</strong> ${currency} ${investedAmount.toFixed(2)}</li>
      <li><strong>Wealth Gained:</strong> ${currency} ${returns.toFixed(2)}</li>
    </ul>
  `;

  drawSIPChart(investedAmount, returns);
}

function drawSIPChart(invested, gains) {
  const ctx = document.getElementById('sipChart').getContext('2d');
  if (window.sipChart) window.sipChart.destroy();
  window.sipChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Invested Amount', 'Wealth Gained'],
      datasets: [{
        data: [invested, gains],
        backgroundColor: ['#2196F3', '#FF5722']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadSIPPdf() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("SIP Investment Result", 10, 10);
  const content = document.getElementById('sipResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("sip-result.pdf");
}
</script>
