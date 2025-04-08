<div class="fcp-container">
  <h1 class="fcp-title">Finance Calculators</h1>
  <p class="fcp-subtitle">Calculate smart. Plan better. Grow faster.</p>

  <!-- 🌗 Dark Mode Toggle Button -->
  <button id="fcp-theme-toggle" style="position: fixed; top: 15px; right: 15px; z-index: 999;">
    🌓 Toggle Theme
  </button>

  <!-- 💰 AdSense Placeholder -->
  <div class="fcp-ad" style="margin: 20px 0; text-align:center;">
    <p style="font-size: 14px; color: gray;">[Your Google AdSense Ad Here]</p>
  </div>

  <div class="fcp-grid">
    <?php
    $categories = [
      ['Loan & Debt', 'loan-icon.svg'],
      ['Investment & Wealth', 'investment-icon.svg'],
      ['Tax Calculators', 'tax-icon.svg'],
      ['Business Tools', 'business-icon.svg'],
      ['Personal Finance', 'personal-icon.svg'],
      ['Real Estate', 'realestate-icon.svg'],
      ['Cryptocurrency', 'crypto-icon.svg'],
      ['Retirement Tools', 'retirement-icon.svg'],
      ['Insurance Tools', 'insurance-icon.svg'],
      ['Education Planning', 'education-icon.svg'],
      ['Global Finance', 'global-icon.svg'],
      ['Niche Tools', 'niche-icon.svg']
    ];

    foreach ($categories as $index => $cat) {
      echo '<a class="fcp-grid-item" href="/calculator-category-' . ($index+1) . '">
              <img src="' . FCP_URL . 'assets/icons/' . $cat[1] . '" alt="' . $cat[0] . ' Icon">
              <span>' . $cat[0] . '</span>
            </a>';
    }
    ?>
  </div>
</div>
