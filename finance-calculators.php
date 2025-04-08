<?php
/*
Plugin Name: Finance Calculators Plugin
Description: A sleek and SEO-friendly plugin offering 12 categories of finance calculators.
Version: 1.0
Author: Your Name
*/

define('FCP_DIR', plugin_dir_path(__FILE__));
define('FCP_URL', plugin_dir_url(__FILE__));

function fcp_enqueue_assets() {
    wp_enqueue_style('fcp-style', FCP_URL . 'css/style.css');
    wp_enqueue_script('fcp-script', FCP_URL . 'js/script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'fcp_enqueue_assets');

include_once FCP_DIR . 'includes/functions.php';

function fcp_homepage_grid() {
    ob_start();
    include FCP_DIR . 'templates/homepage.php';
    return ob_get_clean();
}
add_shortcode('finance_calculators_home', 'fcp_homepage_grid');

// style.css
.fcp-container {
  text-align: center;
  padding: 40px;
  font-family: 'Arial', sans-serif;
}
.fcp-title {
  font-size: 2.5rem;
  margin-bottom: 10px;
}
.fcp-subtitle {
  font-size: 1.2rem;
  color: #777;
  margin-bottom: 30px;
}
.fcp-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}
.fcp-grid-item {
  padding: 20px;
  border-radius: 12px;
  background: #f2f2f2;
  transition: 0.3s;
  text-decoration: none;
  color: #333;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.fcp-grid-item:hover {
  background: #d9e9ff;
  color: #000;
}
.fcp-grid-item img {
  width: 60px;
  margin-bottom: 10px;
}

// script.js
document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('fcp-theme-toggle');
  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      document.body.classList.toggle('fcp-dark-mode');
    });
  }
});

// homepage.php
<div class="fcp-container">
  <h1 class="fcp-title">Finance Calculators</h1>
  <p class="fcp-subtitle">Calculate smart. Plan better. Grow faster.</p>
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
