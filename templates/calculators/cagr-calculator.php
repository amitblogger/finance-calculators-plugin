<div class="fcp-container">
  <h2>CAGR Calculator</h2>
  <p><em>Calculate Compound Annual Growth Rate of your investment</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="cagrForm">
    <label>Initial Value: <input type="number" id="cagrStart" required></label><br><br>
    <label>Final Value: <input type="number" id="cagrEnd" required></label><br><br>
    <label>Investment Duration (Years): <input type="number" id="cagrYears" required></label><br><br>
    <label>Currency:
      <select id="cagrCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateCAGR()">Calculate CAGR</button>
  </form>

  <div id="cagrResult" style="margin-top: 20px;"></div>
  <canvas id="cagrChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadCAGRPDF()">Export to PDF</button></div>
</div>

<script>
function calculateCAGR() {
  const start = parseFloat(document.getElementById('cagrStart').value);
  const end = parseFloat(document.getElementById('cagrEnd').value);
  const years = parseFloat(document.getElementById('cagrYears').value);
  const currency = document.getElementById('cagrCurrency').value;

  if (isNaN(start) || isNaN(end) || isNaN(years) || start <= 0) {
    document.getElementById('cagrResult').innerHTML = "<p>Enter valid numbers (start > 0).</p>";
    return;
  }

  const cagr = (Math.pow(end / start, 1 / years) - 1) * 100;
  const gain = end - start;

  document.getElementById('cagrResult').innerHTML = `
    <h3>CAGR: ${cagr.toFixed(2)}%</h3>
    <ul>
      <li><strong>Initial Investment:</strong> ${currency} ${start.toFixed(2)}</li>
      <li><strong>Final Value:</strong> ${currency} ${end.toFixed(2)}</li>
      <li><strong>Total Gain:</strong> ${currency} ${gain.toFixed(2)}</li>
    </ul>
  `;

  drawCAGRChart(start, gain);
}

function drawCAGRChart(start, gain) {
  const ctx = document.getElementById('cagrChart').getContext('2d');
  if (window.cagrChart) window.cagrChart.destroy();
  window.cagrChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Initial Value', 'Gain'],
      datasets: [{
        data: [start, gain],
        backgroundColor: ['#00BCD4', '#FFC107']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadCAGRPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("CAGR Result", 10, 10);
  const content = document.getElementById('cagrResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("cagr-result.pdf");
}
</script>
