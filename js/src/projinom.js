import $ from "jquery";
window.$ = $;

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';

import 'prismjs';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-bash';
import 'prismjs/components/prism-javascript';
import 'prismjs/components/prism-typescript';
import 'prismjs/components/prism-php';
import 'prismjs/themes/prism-tomorrow.min.css';

import './projinom.scss';

$('#sidebar .nav-item:first button').trigger('click');
