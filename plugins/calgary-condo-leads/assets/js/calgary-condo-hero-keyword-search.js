(function () {
  document.addEventListener('submit', function (event) {
    var form = event.target.closest('.ccl-keyword-search-form');

    if (!form) {
      return;
    }

    event.preventDefault();

    var input = form.querySelector('#ccl-hero-keyword-search');
    var keyword = input && input.value ? input.value.trim() : '';
    var baseUrl = form.getAttribute('action') || '/calgary-condos/';

    if (baseUrl.indexOf('?') !== -1) {
      baseUrl = baseUrl.split('?')[0];
    }

    if (baseUrl.charAt(baseUrl.length - 1) !== '/') {
      baseUrl += '/';
    }

    if (!keyword) {
      window.location.href = baseUrl;
      return;
    }

    window.location.href = baseUrl + '?keyword=' + encodeURIComponent(keyword);
  });
})();
