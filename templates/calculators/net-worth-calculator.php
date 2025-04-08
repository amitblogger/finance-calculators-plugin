<div class="fcp-container">
  <h2>Net Worth Calculator</h2>
  <p><em>Calculate your current net worth by subtracting liabilities from assets</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="networthForm">
    <h4>Assets</h4>
    <label>Cash & Bank: <input type="number" id="assetCash"></label><br>
    <label>Investments: <input type="number" id="assetInvestments"></label><br>
    <label>Real Estate: <input type="number" id="assetProperty"></label><br>
    <label>Other Assets: <input type="number" id="assetOthers"></label><br><br>

    <h4>Liabilities</h4>
    <label>Home Loan: <input type="number" id="debtHome"></label><br>
    <label>Personal Loan: <input type="number" id="debtPersonal"></label><br>
    <label>Credit Card Debt: <input type="number" id="debtCard"></label><br>
    <label>Other Liabilities: <input type="number" id="debtOther"></label><br><br>

    <label>Currency:
      <select id="nwCurrency">
        <option value="USD">USD</option>
        <option value="INR">INR</option>
        <option value="EUR">EUR</option>
        <option value="GBP">GBP</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>

    <button type="button" onclick="calculateNetWorth()">Calculate</button>
  </form>

  <div id="networthResult" style="margin-top: 20px;"></div>
  <canvas id="networthChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadNetWorthPDF()">Export to PDF</button></div>
</div>

<script>
function calculateNetWorth() {
  const assets = [
    parseFloat(document.getElementById('assetCash').value) || 0,
    parseFloat(document.getElementById('assetInvestments').value) || 0,
    parseFloat(document.getElementById('assetProperty').value) || 0,
    parseFloat(document.getElementById('assetOthers').value) || 0
  ];
  const liabilities = [
    parseFloat(document.getElementById('debtHome').value) || 0,
    parseFloat(document.getElementById('debtPersonal').value) || 0,
    parseFloat(document.getElementById('debtCard').value) || 0,
    parseFloat(document.getElementById('debtOther').value) || 0
  ];
  const currency = document.getElementById('nwCurrency').value;

  const totalAssets = assets.reduce((a, b) => a + b, 0);
  const totalLiabilities = liabilities.reduce((a, b) => a + b, 0);
  const netWorth = totalAssets - totalLiabilities;

  document.getElementById('networthResult').innerHTML = `
    <h3>Your Net Worth: ${currency} ${netWorth.toFixed(2)}</h3>
    <ul>
      <li><strong>Total Assets:</strong> ${currency} ${totalAssets.toFixed(2)}</li>
      <li><strong>Total Liabilities:</strong> ${currency} ${totalLiabilities.toFixed(2)}</li>
    </ul>
  `;

  drawNetWorthChart(totalAssets, totalLiabilities);
}

function drawNetWorthChart(assets, debts) {
  const ctx = document.getElementById('networthChart').getContext('2d');
  if (window.nwChart) window.nwChart.destroy();
  window.nwChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Assets', 'Liabilities'],
      datasets: [{
        data: [assets, debts],
        backgroundColor: ['#009688', '#F44336']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadNetWorthPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Net Worth Calculator Result", 10, 10);
  const content = document.getElementById('networthResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("net-worth.pdf");
}
</script>
