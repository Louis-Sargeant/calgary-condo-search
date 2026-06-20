(function () {
  document.addEventListener('submit', function (event) {
    const form = event.target.closest('.ccl-keyword-search-form');
    if (!form) {
      return;
    }

    event.preventDefault();

    const input = form.querySelector('#ccl-hero-keyword-search');
    const keyword = input ? input.value.trim() : '';

    if (keyword.length > 0) {
      window.location.href = '/search/?keyword=' + encodeURIComponent(keyword);
      return;
    }

    window.location.href = '/search/';
  });
}());
