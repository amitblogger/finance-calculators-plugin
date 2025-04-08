<div class="fcp-container">
  <h2>Debt Payoff Calculator</h2>
  <p><em>Compare Snowball vs. Avalanche strategy for up to 3 debts</em></p>

  <form id="debtForm">
    <div style="margin-bottom:20px;"><strong>Enter details for up to 3 debts:</strong></div>
    
    <!-- Debt 1 -->
    <label>Debt 1 Amount: <input type="number" id="amount1" required></label><br>
    <label>Interest Rate (%): <input type="number" id="rate1" required></label><br>
    <label>Minimum Monthly Payment: <input type="number" id="min1" required></label><br><br>

    <!-- Debt 2 -->
    <label>Debt 2 Amount: <input type="number" id="amount2"></label><br>
    <label>Interest Rate (%): <input type="number" id="rate2"></label><br>
    <label>Minimum Monthly Payment: <input type="number" id="min2"></label><br><br>

    <!-- Debt 3 -->
    <label>Debt 3 Amount: <input type="number" id="amount3"></label><br>
    <label>Interest Rate (%): <input type="number" id="rate3"></label><br>
    <label>Minimum Monthly Payment: <input type="number" id="min3"></label><br><br>

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

  <div id="payoffResult" style="margin-top: 30px;"></div>
</div>

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
        rate: rate / 100 / 12, // monthly rate
        minPay
      });
    }
  }

  if (debts.length === 0 || isNaN(budget)) {
    document.getElementById('payoffResult').innerHTML = "<p>Please fill in at least one debt and your budget.</p>";
    return;
  }

  const snowball = JSON.parse(JSON.stringify(debts)).sort((a, b) => a.amount - b.amount);
  const avalanche = JSON.parse(JSON.stringify(debts)).sort((a, b) => b.rate - a.rate);

  const snowballMonths = simulatePayoff(snowball, budget);
  const avalancheMonths = simulatePayoff(avalanche, budget);

  document.getElementById('payoffResult').innerHTML = `
    <h3>Results</h3>
    <ul>
      <li><strong>Snowball Method:</strong> Pay off in <b>${snowballMonths}</b> months.</li>
      <li><strong>Avalanche Method:</strong> Pay off in <b>${avalancheMonths}</b> months.</li>
    </ul>
    <p><em>Snowball prioritizes smallest balance first. Avalanche prioritizes highest interest rate.</em></p>
  `;
}

function simulatePayoff(debts, budget) {
  let month = 0;
  while (debts.some(d => d.amount > 0) && month < 600) { // max 50 years cap
    month++;
    let extra = budget;

    for (let i = 0; i < debts.length; i++) {
      if (debts[i].amount <= 0) continue;

      const interest = debts[i].amount * debts[i].rate;
      let payment = debts[i].minPay;

      if (i === 0) {
        // Extra goes to first debt
        payment = Math.min(debts[i].amount + interest, extra);
      }

      debts[i].amount += interest - payment;
      if (debts[i].amount < 0) debts[i].amount = 0;

      extra -= payment;
    }
  }
  return month;
}
</script>
