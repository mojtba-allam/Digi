import './bootstrap';
import Alpine from 'alpinejs';
import { Chart, registerables } from 'chart.js';

// Register Chart.js components
Chart.register(...registerables);

// Make Chart.js available globally
window.Chart = Chart;

// Start Alpine.js
window.Alpine = Alpine;
Alpine.start();
