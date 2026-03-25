import './bootstrap';
import { initReportCharts } from './reportes';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.initReportCharts = initReportCharts;

Alpine.start();