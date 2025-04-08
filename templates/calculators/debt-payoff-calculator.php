<div class="fcp-container">
  <h2>Debt Payoff Calculator</h2>
  <p><em>Compare Snowball vs. Avalanche strategy for up to 3 debts</em></p>

  <form id="debtForm">
    <div><strong>Enter details for up to 3 debts:</strong></div>

    <!-- Debt 1 -->
    <label>Debt 1 Amount: <input type="number" id="amount1" required></label><br>
    <label>Interest Rate (%): <input type="number" id="rate1" required></label><br>
    <label>Min Monthly Payment: <input type="number" id="min1" required></label><br><br>

    <!-- Debt 2 -->
    <label>Debt 2 Amount: <input type="number" id="amount2"></label><br>
    <label>Interest Rate (%): <input type="number" id="rate2"></label><br>
    <label>Min Monthly Payment: <input type="number" id="min2"></label><br><br>

    <!-- Debt 3 -->
    <label>Debt 3 Amount: <input type="number" id="amount3"></label><br>
    <label>Interest Rate (%): <input type="number" id="rate3"></label><br>
    <label>Min Monthly Payment: <input type="number" id="min3"></label><br><br>

    <label>Total Monthly Budget for Debt Repayment:
      <input type="number" id="budget" required>
    </label><br><br>

    <label>Currency:
      <select id="currency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>

    <button type="button" onclick="calculatePayoff()">Compare Strategies</button>
  </form>

  <div id="payoffResult" style="margin-top: 20px;"></div>
  <canvas id="payoffChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadPayoffPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculatePayoff() {
  const debts = [];
  const budget = parseFloat(document.getElementById('budget').value);
  const currency = document.getElementById('currency').value;

  for (let i = 1; i <= 3; i++) {
    const amount = parseFloat(document.getElementById('amount' + i).value);
    const rate = parseFloat(document.getElementById('rate' + i).value);
    const minPay = parseFloat(document.getElementById('min' + i).value);
    if (!isNaN(amount) && !isNaN(rate) && !isNaN(minPay)) {
      debts.push({
        name: `Debt ${i}`,
        amount,
        rate: rate / 100 / 12,
        minPay
      });
    }
  }

  if (debts.length === 0 || isNaN(budget)) {
    document.getElementById('payoffResult').innerHTML = "<p>Please enter at least one debt and your budget.</p>";
    return;
  }

  const snowball = JSON.parse(JSON.stringify(debts)).sort((a, b) => a.amount - b.amount);
  const avalanche = JSON.parse(JSON.stringify(debts)).sort((a, b) => b.rate - a.rate);

  const snowballMonths = simulatePayoff(snowball, budget);
  const avalancheMonths = simulatePayoff(avalanche, budget);

  document.getElementById('payoffResult').innerHTML = `
    <h3>Strategy Comparison</h3>
    <ul>
      <li><strong>Snowball Method:</strong> ${snowballMonths} months</li>
      <li><strong>Avalanche Method:</strong> ${avalancheMonths} months</li>
    </ul>
    <p><em>Snowball = Smallest balance first<br>Avalanche = Highest interest first</em></p>
  `;

  drawPayoffChart(snowballMonths, avalancheMonths);
}

function simulatePayoff(debts, budget) {
  let month = 0;
  while (debts.some(d => d.amount > 0) && month < 600) {
    month++;
    let extra = budget;
    for (let i = 0; i < debts.length; i++) {
      if (debts[i].amount <= 0) continue;

      const interest = debts[i].amount * debts[i].rate;
      let payment = debts[i].minPay;
      if (i === 0) {
        payment = Math.min(debts[i].amount + interest, extra);
      }

      debts[i].amount += interest - payment;
      if (debts[i].amount < 0) debts[i].amount = 0;

      extra -= payment;
    }
  }
  return month;
}

function drawPayoffChart(snowball, avalanche) {
  const ctx = document.getElementById('payoffChart').getContext('2d');
  if (window.dpChart) window.dpChart.destroy();
  window.dpChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Snowball', 'Avalanche'],
      datasets: [{
        label: 'Months to Pay Off',
        data: [snowball, avalanche],
        backgroundColor: ['#2196F3', '#FF9800']
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        tooltip: { callbacks: {
          label: function(ctx) {
            return `${ctx.raw} months`;
          }
        }}
      },
      scales: {
        y: { beginAtZero: true, title: { display: true, text: 'Months' } }
      }
    }
  });
}

function downloadPayoffPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Debt Payoff Comparison", 10, 10);
  const content = document.getElementById('payoffResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("debt-payoff.pdf");
}
</script>
