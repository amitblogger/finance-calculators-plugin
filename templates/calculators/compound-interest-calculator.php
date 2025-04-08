<div class="fcp-container">
  <h2>Compound Interest Calculator</h2>
  <p><em>Calculate interest on your investment with compounding</em></p>

  <!-- 💰 AdSense Placeholder -->
  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="ciForm">
    <label>Principal Amount: <input type="number" id="ciPrincipal" required></label><br><br>
    <label>Annual Interest Rate (%): <input type="number" id="ciRate" required></label><br><br>
    <label>Time (Years): <input type="number" id="ciTime" required></label><br><br>
    <label>Compounded:
      <select id="ciFrequency">
        <option value="1">Annually</option>
        <option value="2">Semi-Annually</option>
        <option value="4">Quarterly</option>
        <option value="12">Monthly</option>
      </select>
    </label><br><br>
    <label>Currency:
      <select id="ciCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateCompoundInterest()">Calculate</button>
  </form>

  <div id="ciResult" style="margin-top: 20px;"></div>
  <canvas id="ciChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadCIPDF()">Export Result to PDF</button></div>
</div>

<!-- Required Libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculateCompoundInterest() {
  const P = parseFloat(document.getElementById('ciPrincipal').value);
  const r = parseFloat(document.getElementById('ciRate').value) / 100;
  const t = parseFloat(document.getElementById('ciTime').value);
  const n = parseInt(document.getElementById('ciFrequency').value);
  const currency = document.getElementById('ciCurrency').value;

  if (isNaN(P) || isNaN(r) || isNaN(t) || isNaN(n)) {
    document.getElementById('ciResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const amount = P * Math.pow((1 + r / n), n * t);
  const interest = amount - P;

  document.getElementById('ciResult').innerHTML = `
    <h3>Total Value: ${currency} ${amount.toFixed(2)}</h3>
    <ul>
      <li><strong>Principal:</strong> ${currency} ${P.toFixed(2)}</li>
      <li><strong>Total Interest Earned:</strong> ${currency} ${interest.toFixed(2)}</li>
    </ul>
  `;

  drawCIChart(P, interest);
}

function drawCIChart(principal, interest) {
  const ctx = document.getElementById('ciChart').getContext('2d');
  if (window.ciChart) window.ciChart.destroy();
  window.ciChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Principal', 'Interest Earned'],
      datasets: [{
        data: [principal, interest],
        backgroundColor: ['#4CAF50', '#FFC107']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadCIPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Compound Interest Result", 10, 10);
  const content = document.getElementById('ciResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("compound-interest-result.pdf");
}
</script>
