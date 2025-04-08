<div class="fcp-container">
  <h2>401(k) Retirement Calculator</h2>
  <p><em>Estimate your 401(k) savings at retirement</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="k401Form">
    <label>Current Balance: <input type="number" id="k401Current" required></label><br><br>
    <label>Annual Contribution: <input type="number" id="k401Annual" required></label><br><br>
    <label>Years to Retirement: <input type="number" id="k401Years" required></label><br><br>
    <label>Expected Annual Return (%): <input type="number" id="k401Rate" required></label><br><br>
    <label>Currency:
      <select id="k401Currency">
        <option value="USD">USD</option>
        <option value="INR">INR</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculate401k()">Calculate</button>
  </form>

  <div id="k401Result" style="margin-top: 20px;"></div>
  <canvas id="k401Chart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="download401kPDF()">Export to PDF</button></div>
</div>

<script>
function calculate401k() {
  const balance = parseFloat(document.getElementById('k401Current').value);
  const contribution = parseFloat(document.getElementById('k401Annual').value);
  const years = parseFloat(document.getElementById('k401Years').value);
  const rate = parseFloat(document.getElementById('k401Rate').value) / 100;
  const currency = document.getElementById('k401Currency').value;

  if (isNaN(balance) || isNaN(contribution) || isNaN(years) || isNaN(rate)) {
    document.getElementById('k401Result').innerHTML = "<p>Please enter all values.</p>";
    return;
  }

  let futureValue = balance * Math.pow(1 + rate, years);
  for (let i = 1; i <= years; i++) {
    futureValue += contribution * Math.pow(1 + rate, years - i);
  }

  const totalContribution = balance + (contribution * years);
  const gain = futureValue - totalContribution;

  document.getElementById('k401Result').innerHTML = `
    <h3>401(k) Future Value: ${currency} ${futureValue.toFixed(2)}</h3>
    <ul>
      <li><strong>Total Contributions:</strong> ${currency} ${totalContribution.toFixed(2)}</li>
      <li><strong>Growth:</strong> ${currency} ${gain.toFixed(2)}</li>
    </ul>
  `;

  draw401kChart(totalContribution, gain);
}

function draw401kChart(principal, gain) {
  const ctx = document.getElementById('k401Chart').getContext('2d');
  if (window.k401Chart) window.k401Chart.destroy();
  window.k401Chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Contributions', 'Growth'],
      datasets: [{
        data: [principal, gain],
        backgroundColor: ['#03A9F4', '#8BC34A']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function download401kPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("401(k) Calculator Result", 10, 10);
  const content = document.getElementById('k401Result');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("401k-calculator.pdf");
}
</script>
