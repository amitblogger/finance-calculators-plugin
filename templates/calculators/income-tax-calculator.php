<div class="fcp-container">
  <h2>Income Tax Calculator</h2>
  <p><em>Calculate your income tax liability (Old Regime - India)</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="incomeTaxForm">
    <label>Annual Income (INR): <input type="number" id="itIncome" required></label><br><br>
    <label>Deductions (80C, 80D, etc.): <input type="number" id="itDeduction" value="0"></label><br><br>
    <button type="button" onclick="calculateIncomeTax()">Calculate</button>
  </form>

  <div id="itResult" style="margin-top: 20px;"></div>
  <canvas id="itChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadIncomeTaxPDF()">Export to PDF</button></div>
</div>

<script>
function calculateIncomeTax() {
  let income = parseFloat(document.getElementById('itIncome').value);
  let deduction = parseFloat(document.getElementById('itDeduction').value) || 0;
  let taxable = income - deduction;
  if (taxable <= 0) taxable = 0;

  let tax = 0;
  if (taxable > 250000 && taxable <= 500000) tax = 0.05 * (taxable - 250000);
  else if (taxable > 500000 && taxable <= 1000000)
    tax = 12500 + 0.2 * (taxable - 500000);
  else if (taxable > 1000000)
    tax = 112500 + 0.3 * (taxable - 1000000);

  let postTaxIncome = income - tax;

  document.getElementById('itResult').innerHTML = `
    <h3>Tax Payable: ₹${tax.toFixed(2)}</h3>
    <ul>
      <li><strong>Gross Income:</strong> ₹${income.toFixed(2)}</li>
      <li><strong>Deductions:</strong> ₹${deduction.toFixed(2)}</li>
      <li><strong>Net Income after Tax:</strong> ₹${postTaxIncome.toFixed(2)}</li>
    </ul>
  `;

  const ctx = document.getElementById('itChart').getContext('2d');
  if (window.itChart) window.itChart.destroy();
  window.itChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Tax Payable', 'Net Income'],
      datasets: [{
        data: [tax, postTaxIncome],
        backgroundColor: ['#F44336', '#4CAF50']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadIncomeTaxPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Income Tax Calculation", 10, 10);
  const content = document.getElementById('itResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("income-tax-result.pdf");
}
</script>
