<div class="fcp-container">
  <h2>ROI Calculator</h2>
  <p><em>Calculate Return on Investment percentage</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="roiForm">
    <label>Investment Cost: <input type="number" id="roiCost" required></label><br><br>
    <label>Final Value: <input type="number" id="roiFinal" required></label><br><br>
    <label>Currency:
      <select id="roiCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateROI()">Calculate ROI</button>
  </form>

  <div id="roiResult" style="margin-top: 20px;"></div>
  <canvas id="roiChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadROIPdf()">Export Result to PDF</button></div>
</div>

<script>
function calculateROI() {
  const cost = parseFloat(document.getElementById('roiCost').value);
  const final = parseFloat(document.getElementById('roiFinal').value);
  const currency = document.getElementById('roiCurrency').value;

  if (isNaN(cost) || isNaN(final)) {
    document.getElementById('roiResult').innerHTML = "<p>Please enter valid numbers.</p>";
    return;
  }

  const roi = ((final - cost) / cost) * 100;
  const gain = final - cost;

  document.getElementById('roiResult').innerHTML = `
    <h3>ROI: ${roi.toFixed(2)}%</h3>
    <ul>
      <li><strong>Investment Cost:</strong> ${currency} ${cost.toFixed(2)}</li>
      <li><strong>Net Gain:</strong> ${currency} ${gain.toFixed(2)}</li>
    </ul>
  `;

  drawROIChart(cost, gain);
}

function drawROIChart(cost, gain) {
  const ctx = document.getElementById('roiChart').getContext('2d');
  if (window.roiChart) window.roiChart.destroy();
  window.roiChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Investment Cost', 'Net Gain'],
      datasets: [{
        data: [cost, gain],
        backgroundColor: ['#3F51B5', '#FF9800']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadROIPdf() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Return on Investment Result", 10, 10);
  const content = document.getElementById('roiResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("roi-result.pdf");
}
</script>
