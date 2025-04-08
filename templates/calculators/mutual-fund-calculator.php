<div class="fcp-container">
  <h2>Mutual Fund Calculator</h2>
  <p><em>Estimate your returns from a lump sum mutual fund investment</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="mfForm">
    <label>Investment Amount: <input type="number" id="mfAmount" required></label><br><br>
    <label>Expected Annual Return (%): <input type="number" id="mfRate" required></label><br><br>
    <label>Investment Period (Years): <input type="number" id="mfYears" required></label><br><br>
    <label>Currency:
      <select id="mfCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateMF()">Calculate</button>
  </form>

  <div id="mfResult" style="margin-top: 20px;"></div>
  <canvas id="mfChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadMFPDF()">Export to PDF</button></div>
</div>

<script>
function calculateMF() {
  const P = parseFloat(document.getElementById('mfAmount').value);
  const r = parseFloat(document.getElementById('mfRate').value) / 100;
  const t = parseFloat(document.getElementById('mfYears').value);
  const currency = document.getElementById('mfCurrency').value;

  if (isNaN(P) || isNaN(r) || isNaN(t)) {
    document.getElementById('mfResult').innerHTML = "<p>Please enter valid numbers.</p>";
    return;
  }

  const FV = P * Math.pow(1 + r, t);
  const gain = FV - P;

  document.getElementById('mfResult').innerHTML = `
    <h3>Maturity Value: ${currency} ${FV.toFixed(2)}</h3>
    <ul>
      <li><strong>Investment:</strong> ${currency} ${P.toFixed(2)}</li>
      <li><strong>Returns:</strong> ${currency} ${gain.toFixed(2)}</li>
    </ul>
  `;

  drawMFChart(P, gain);
}

function drawMFChart(principal, gain) {
  const ctx = document.getElementById('mfChart').getContext('2d');
  if (window.mfChart) window.mfChart.destroy();
  window.mfChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Investment', 'Returns'],
      datasets: [{
        data: [principal, gain],
        backgroundColor: ['#673AB7', '#FF9800']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadMFPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Mutual Fund Investment Result", 10, 10);
  const content = document.getElementById('mfResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("mutual-fund.pdf");
}
</script>
