<div class="fcp-container">
  <h2>Dividend Reinvestment (DRIP) Calculator</h2>
  <p><em>Estimate your investment growth with reinvested dividends</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="dripForm">
    <label>Initial Investment: <input type="number" id="dripInitial" required></label><br><br>
    <label>Annual Dividend Yield (%): <input type="number" id="dripYield" required></label><br><br>
    <label>Annual Stock Growth Rate (%): <input type="number" id="dripGrowth" required></label><br><br>
    <label>Investment Period (Years): <input type="number" id="dripYears" required></label><br><br>
    <label>Currency:
      <select id="dripCurrency">
        <option value="USD">USD</option>
        <option value="INR">INR</option>
        <option value="EUR">EUR</option>
        <option value="GBP">GBP</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateDRIP()">Calculate</button>
  </form>

  <div id="dripResult" style="margin-top: 20px;"></div>
  <canvas id="dripChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadDRIPPDF()">Export to PDF</button></div>
</div>

<script>
function calculateDRIP() {
  const initial = parseFloat(document.getElementById('dripInitial').value);
  const yieldRate = parseFloat(document.getElementById('dripYield').value) / 100;
  const growthRate = parseFloat(document.getElementById('dripGrowth').value) / 100;
  const years = parseFloat(document.getElementById('dripYears').value);
  const currency = document.getElementById('dripCurrency').value;

  if (isNaN(initial) || isNaN(yieldRate) || isNaN(growthRate) || isNaN(years)) {
    document.getElementById('dripResult').innerHTML = "<p>Please enter all values.</p>";
    return;
  }

  const totalRate = yieldRate + growthRate;
  const futureValue = initial * Math.pow(1 + totalRate, years);
  const earnings = futureValue - initial;

  document.getElementById('dripResult').innerHTML = `
    <h3>Total Value with DRIP: ${currency} ${futureValue.toFixed(2)}</h3>
    <ul>
      <li><strong>Initial Investment:</strong> ${currency} ${initial.toFixed(2)}</li>
      <li><strong>Total Earnings:</strong> ${currency} ${earnings.toFixed(2)}</li>
    </ul>
  `;

  drawDRIPChart(initial, earnings);
}

function drawDRIPChart(principal, gain) {
  const ctx = document.getElementById('dripChart').getContext('2d');
  if (window.dripChart) window.dripChart.destroy();
  window.dripChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Initial Investment', 'Earnings'],
      datasets: [{
        data: [principal, gain],
        backgroundColor: ['#4CAF50', '#FF9800']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadDRIPPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("DRIP Calculator Result", 10, 10);
  const content = document.getElementById('dripResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("drip-result.pdf");
}
</script>
