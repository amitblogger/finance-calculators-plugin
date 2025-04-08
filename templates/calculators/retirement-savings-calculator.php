<div class="fcp-container">
  <h2>Retirement Savings Calculator</h2>
  <p><em>Estimate how much money you’ll have by retirement</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="retireForm">
    <label>Current Savings: <input type="number" id="retireNow" required></label><br><br>
    <label>Monthly Contribution: <input type="number" id="retireMonthly" required></label><br><br>
    <label>Expected Annual Return (%): <input type="number" id="retireRate" required></label><br><br>
    <label>Years Until Retirement: <input type="number" id="retireYears" required></label><br><br>
    <label>Currency:
      <select id="retireCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateRetirement()">Calculate</button>
  </form>

  <div id="retireResult" style="margin-top: 20px;"></div>
  <canvas id="retireChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadRetirePDF()">Export to PDF</button></div>
</div>

<script>
function calculateRetirement() {
  const current = parseFloat(document.getElementById('retireNow').value);
  const monthly = parseFloat(document.getElementById('retireMonthly').value);
  const rate = parseFloat(document.getElementById('retireRate').value) / 100 / 12;
  const years = parseFloat(document.getElementById('retireYears').value);
  const months = years * 12;
  const currency = document.getElementById('retireCurrency').value;

  if (isNaN(current) || isNaN(monthly) || isNaN(rate) || isNaN(years)) {
    document.getElementById('retireResult').innerHTML = "<p>Please enter all values.</p>";
    return;
  }

  let futureValue = current * Math.pow(1 + rate, months);
  futureValue += monthly * ((Math.pow(1 + rate, months) - 1) / rate) * (1 + rate);

  const invested = current + (monthly * months);
  const growth = futureValue - invested;

  document.getElementById('retireResult').innerHTML = `
    <h3>Estimated Retirement Corpus: ${currency} ${futureValue.toFixed(2)}</h3>
    <ul>
      <li><strong>Total Contributions:</strong> ${currency} ${invested.toFixed(2)}</li>
      <li><strong>Estimated Growth:</strong> ${currency} ${growth.toFixed(2)}</li>
    </ul>
  `;

  drawRetireChart(invested, growth);
}

function drawRetireChart(principal, gain) {
  const ctx = document.getElementById('retireChart').getContext('2d');
  if (window.retireChart) window.retireChart.destroy();
  window.retireChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Contributions', 'Growth'],
      datasets: [{
        data: [principal, gain],
        backgroundColor: ['#4CAF50', '#FF9800']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadRetirePDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Retirement Savings Result", 10, 10);
  const content = document.getElementById('retireResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("retirement-savings.pdf");
}
</script>
