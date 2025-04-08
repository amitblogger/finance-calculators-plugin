<div class="fcp-container">
  <h2>GST/VAT Calculator</h2>
  <p><em>Calculate GST/VAT amount & total price</em></p>

  <div class="fcp-ad"><p>[Your Google AdSense Ad Here]</p></div>

  <form id="gstForm">
    <label>Base Price: <input type="number" id="gstBase" required></label><br><br>
    <label>GST/VAT Rate (%): <input type="number" id="gstRate" required></label><br><br>
    <label>Type:
      <select id="gstType">
        <option value="add">Add GST</option>
        <option value="remove">Remove GST</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateGST()">Calculate</button>
  </form>

  <div id="gstResult" style="margin-top: 20px;"></div>
  <canvas id="gstChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;"><button onclick="downloadGSTPDF()">Export to PDF</button></div>
</div>

<script>
function calculateGST() {
  const price = parseFloat(document.getElementById('gstBase').value);
  const rate = parseFloat(document.getElementById('gstRate').value);
  const type = document.getElementById('gstType').value;

  let gst = 0, total = 0;

  if (type === 'add') {
    gst = (price * rate) / 100;
    total = price + gst;
  } else {
    gst = (price * rate) / (100 + rate);
    total = price - gst;
  }

  document.getElementById('gstResult').innerHTML = `
    <h3>${type === 'add' ? 'Total Price with GST:' : 'Base Price without GST:'} ₹${total.toFixed(2)}</h3>
    <ul>
      <li><strong>GST Amount:</strong> ₹${gst.toFixed(2)}</li>
      <li><strong>${type === 'add' ? 'Original Price:' : 'Total Price:'}</strong> ₹${price.toFixed(2)}</li>
    </ul>
  `;

  const ctx = document.getElementById('gstChart').getContext('2d');
  if (window.gstChart) window.gstChart.destroy();
  window.gstChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['GST/VAT', 'Net Price'],
      datasets: [{
        data: [gst, total - gst],
        backgroundColor: ['#FF9800', '#03A9F4']
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
  });
}

function downloadGSTPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("GST/VAT Calculation", 10, 10);
  const content = document.getElementById('gstResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("gst-vat-result.pdf");
}
</script>
