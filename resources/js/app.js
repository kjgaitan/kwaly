import './bootstrap';
import { initReportCharts } from './reportes';

import './categorias';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.initReportCharts = initReportCharts;

Alpine.start();