
// Dans app.js
import $ from 'jquery';

(() => {
    window.$ = window.jQuery = $;
    import('./bootstrap.js');
    import('@hotwired/turbo');
    import('./javascript/main.js');

    import('./javascript/niveau.js')

})();



import 'bootstrap/dist/css/bootstrap.min.css';
import '@fortawesome/fontawesome-free/css/all.css';
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
