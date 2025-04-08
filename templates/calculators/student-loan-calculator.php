<div class="fcp-container">
  <h2>Student Loan EMI Calculator</h2>
  <p><em>Estimate your student loan repayment per month</em></p>

  <form id="studentLoanForm">
    <label>Loan Amount: <input type="number" id="sLoanAmount" required></label><br><br>
    <label>Interest Rate (% per annum): <input type="number" id="sInterestRate" required></label><br><br>
    <label>Loan Tenure (Years): <input type="number" id="sTenure" required></label><br><br>
    <label>Currency:
      <select id="sCurrency">
        <option value="INR">INR</option>
        <option value="USD">USD</option>
        <option value="GBP">GBP</option>
        <option value="EUR">EUR</option>
        <option value="AUD">AUD</option>
      </select>
    </label><br><br>
    <button type="button" onclick="calculateStudentLoan()">Calculate EMI</button>
  </form>

  <div id="studentLoanResult" style="margin-top: 20px;"></div>
  <canvas id="studentLoanChart" width="400" height="250" style="margin-top:30px;"></canvas>
  <div style="margin-top: 20px;">
    <button onclick="downloadStudentLoanPDF()">Export Result to PDF</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
function calculateStudentLoan() {
  const P = parseFloat(document.getElementById('sLoanAmount').value);
  const R = parseFloat(document.getElementById('sInterestRate').value) / 12 / 100;
  const N = parseFloat(document.getElementById('sTenure').value) * 12;
  const currency = document.getElementById('sCurrency').value;

  if (isNaN(P) || isNaN(R) || isNaN(N)) {
    document.getElementById('studentLoanResult').innerHTML = "<p>Please enter all values correctly.</p>";
    return;
  }

  const emi = (P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1);
  const totalPayable = emi * N;
  const totalInterest = totalPayable - P;

  document.getElementById('studentLoanResult').innerHTML = `
    <h3>Estimated EMI: ${currency} ${emi.toFixed(2)} / month</h3>
    <ul>
      <li><strong>Total Interest:</strong> ${currency} ${totalInterest.toFixed(2)}</li>
      <li><strong>Total Payment:</strong> ${currency} ${totalPayable.toFixed(2)}</li>
    </ul>
  `;

  drawStudentLoanChart(P, totalInterest);
}

function drawStudentLoanChart(principal, interest) {
  const ctx = document.getElementById('studentLoanChart').getContext('2d');
  if (window.slChart) window.slChart.destroy();
  window.slChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Principal', 'Interest'],
      datasets: [{
        data: [principal, interest],
        backgroundColor: ['#9C27B0', '#FF9800'],
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' }
      }
    }
  });
}

function downloadStudentLoanPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  doc.text("Student Loan EMI Result", 10, 10);
  const content = document.getElementById('studentLoanResult');
  doc.fromHTML(content.innerHTML, 10, 20);
  doc.save("student-loan-emi.pdf");
}
</script>
