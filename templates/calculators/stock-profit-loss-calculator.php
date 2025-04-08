<div class="fcp-container">
  <h2>Stock Market Profit/Loss Calculator</h2>
  <p><em>Calculate your profit or loss from buying and selling stocks</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="stockForm">
    <label>Buy Price: <input type="number" id="buyPrice" required></label><br><br>
    <label>Sell Price: <input type="number" id="sellPrice" required></label><br><br>
    <label>Number of Shares: <input type="number" id="shares" required></label><br><br>
    <label>Currency:
      <select id="stockCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateStockProfit()">Calculate</button>
  </form>

  <div id="stockResult" style="margin-top: 20px;"></div>
  <canvas id="stockChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadStockPDF()">Export to PDF</button></div>
</div>

<script>
function calculateStockProfit() {
  const buy = parseFloat(document.getElementById('buyPrice').value);
  const sell = parseFloat(document.getElementById('sellPrice').value);
  const quantity = parseFloat(document.getElementById('shares').value);
  const currency = document.getElementById('stockCurrency').value;

  if (isNaN(buy) || isNaN(sell) || isNaN(quantity)) {
    document.getElementById('stockResult').innerHTML = "<p>Please enter all values.</p>";
    return;
  }

  const invested = buy * quantity;
  const value = sell * quantity;
  const pnl = value - invested;

  document.getElementById('stockResult').innerHTML = `
    <h3>Net ${pnl >= 0 ? 'Profit' : 'Loss'}: ${currency} ${Math.abs(pnl).toFixed(2)}</h3>
    <ul>
      <li><strong>Invested:</strong> ${currency} ${invested.toFixed(2)}</li>
      <li><strong>Current Value:</strong> ${currency} ${value.toFixed(2)}</li>
    </ul>
  `;

  drawStockChart(invested, pnl);
}

function drawStockChart(invested, pnl) {
  const ctx = document.getElementById('stockChart').getContext('2d');
  if (window.stockChart) window.stockChart.destroy();
  window.stockChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Invested Amount', pnl >= 0 ? 'Profit' : 'Loss'],
      datasets: [{
        data: [invested, Math.abs(pnl)],
        backgroundColor: ['#3F51B5', pnl >= 0 ? '#4CAF50' : '#F44336']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadStockPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Stock Profit/Loss Result", 10, 10);
  const content = document.getElementById('stockResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("stock-profit-loss.pdf");
}
</script>
