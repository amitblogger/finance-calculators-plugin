<div class="fcp-container">
  <h2>Capital Gains Tax Calculator</h2>
  <p><em>Estimate capital gains tax on your asset sales</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="cgForm">
    <label>Purchase Price: <input type="number" id="cgBuy" required></label><br><br>
    <label>Sale Price: <input type="number" id="cgSell" required></label><br><br>
    <label>Holding Period (Years): <input type="number" id="cgYears" required></label><br><br>
    <label>Currency:
      <select id="cgCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateCapitalGains()">Calculate</button>
  </form>

  <div id="cgResult" style="margin-top: 20px;"></div>
  <canvas id="cgChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadCGPDF()">Export to PDF</button></div>
</div>

<script>
function calculateCapitalGains() {
  const buy = parseFloat(document.getElementById('cgBuy').value);
  const sell = parseFloat(document.getElementById('cgSell').value);
  const years = parseFloat(document.getElementById('cgYears').value);
  const currency = document.getElementById('cgCurrency').value;

  if (isNaN(buy) || isNaN(sell) || isNaN(years)) {
    document.getElementById('cgResult').innerHTML = "<p>Enter valid numbers.</p>";
    return;
  }

  const gain = sell - buy;
  let taxRate = years < 3 ? 0.15 : 0.10;
  const tax = gain > 0 ? gain * taxRate : 0;

  document.getElementById('cgResult').innerHTML = `
    <h3>Capital Gains Tax: ${currency} ${tax.toFixed(2)}</h3>
    <ul>
      <li><strong>Gain:</strong> ${currency} ${gain.toFixed(2)}</li>
      <li><strong>Tax Rate Applied:</strong> ${taxRate * 100}%</li>
    </ul>
  `;

  const ctx = document.getElementById('cgChart').getContext('2d');
  if (window.cgChart) window.cgChart.destroy();
  window.cgChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Tax', 'Remaining Gain'],
      datasets: [{
        data: [tax, gain - tax],
        backgroundColor: ['#E91E63', '#8BC34A']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadCGPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Capital Gains Tax Result", 10, 10);
  const content = document.getElementById('cgResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("capital-gains-tax.pdf");
}
</script>
